document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let currentSort = 'default';
    let currentFilters = {};
    const per_page = 9;
    let totalPages = 1;
    
    
    // Initial load
    loadProducts();
    
    // Sort dropdown handler
    document.querySelectorAll('.shop-short-by ul li a').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            currentSort = this.getAttribute('data-sort');
            currentPage = 1;
            loadProducts();
        });
    });
    
    // Filter handlers
    document.querySelectorAll('.product-filter a').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.closest('.product-filter').querySelector('h5').textContent.toLowerCase();
            const filterValue = this.textContent.trim();
            
            if(filterType === 'categories') {
                currentFilters.category = this.getAttribute('data-id');
            } else if(filterType === 'price') {
                currentFilters.price_range = filterValue.replace('$', '').replace('£', '').replace('+', '');
            }
            // Add more filter types as needed
            
            currentPage = 1;
            loadProducts();
        });
    });
    
    // Pagination handlers
    document.querySelector('.pagination-box').addEventListener('click', function(e) {
        e.preventDefault();
        if(e.target.classList.contains('Previous') && currentPage > 1) {
            currentPage--;
            loadProducts();
        } else if(e.target.classList.contains('Next') && currentPage < totalPages) {
            currentPage++;
            loadProducts();
        } else if(e.target.tagName === 'A' && !isNaN(parseInt(e.target.textContent))) {
            currentPage = parseInt(e.target.textContent);
            loadProducts();
        }
    });
    
    // View type handlers (grid/list)
    document.querySelectorAll('.toolber-tab-menu a').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const viewType = this.getAttribute('href').replace('#tab_columns_', '');
            localStorage.setItem('productViewType', viewType);
            renderProducts(); // Re-render with same data but different view
        });
    });
    
    function loadProducts() {
        const params = new URLSearchParams();
        params.append('page', currentPage);
        params.append('sort', currentSort);
        
        // Add filters to params
        for(const key in currentFilters) {
            if(currentFilters[key] !== null) {
                params.append(key, currentFilters[key]);
            }
        }
        
        fetch(`../../ajax/product_handler.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                renderProducts(data.products);
                updatePagination(data.pagination);
                updateFilters(data.categories);
                updateResultCount(data.pagination.total);
                totalPages = data.pagination.total_pages;
            })
            .catch(error => console.error('Error:', error));
    }
    
    function renderProducts(products) {
        const container = document.getElementById('products-container');
        container.innerHTML = '';
        
        const viewType = localStorage.getItem('productViewType') || '02'; // Default to 4-column
        
        products.forEach(product => {
            const productHtml = `
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-product-item text-center">
                        <div class="products-images">
                            <a href="product-details.php?id=${product.id}" class="product-thumbnail">
                                <img src="${product.image}" class="img-fluid" alt="${product.name}" width="300" height="300">
                                ${product.stock_status === 'out_of_stock' ? '<span class="ribbon out-of-stock">Out Of Stock</span>' : ''}
                            </a>
                            <div class="product-actions">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#prodect-modal" data-id="${product.id}"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                <a href="add-to-cart.php?id=${product.id}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                <a href="wishlist.php?action=add&id=${product.id}"><i class="p-icon icon-heart"></i> <span class="tool-tip">Add to Wishlist</span></a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h6 class="prodect-title"><a href="product-details.php?id=${product.id}">${product.name}</a></h6>
                            <div class="prodect-price">
                                <span class="new-price">£${product.price}</span>
                                ${product.old_price ? ' - <span class="old-price">£' + product.old_price + '</span>' : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', productHtml);
        });
        
        // Initialize quick view modal handlers
        initQuickView();
    }
    
    function updatePagination(pagination) {
        const paginationContainer = document.querySelector('.pagination-box');
        let html = `
            <li>
                <a href="#" class="Previous"><i class="icon-chevron-left"></i></a>
            </li>
        `;
        
        for(let i = 1; i <= pagination.total_pages; i++) {
            html += `<li class="${i === pagination.current_page ? 'active' : ''}"><a href="#">${i}</a></li>`;
        }
        
        html += `
            <li>
                <a href="#" class="Next"><i class="icon-chevron-right"></i></a>
            </li>
        `;
        
        paginationContainer.innerHTML = html;
    }
    
    function updateResultCount(total) {
        const start = ((currentPage - 1) * per_page) + 1;
        const end = Math.min(currentPage * per_page, total);
        document.querySelector('.result-count').textContent = `Showing ${start}–${end} of ${total} results`;
    }
    
    function updateFilters(categories) {
        const categoriesContainer = document.getElementById('categories-filter');
        
        // Clear existing items except "All"
        categoriesContainer.innerHTML = '<li><a href="#" data-id="0">All</a></li>';
        
        // Add categories from the database
        categories.forEach(category => {
            const li = document.createElement('li');
            li.innerHTML = `<a href="#" data-id="${category.id}">${category.name}</a>`;
            categoriesContainer.appendChild(li);
        });
        
        // Add click handlers to new category filters
        categoriesContainer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.getAttribute('data-id');
                currentFilters.category = categoryId !== '0' ? categoryId : null;
                currentPage = 1;
                loadProducts();
            });
        });
    }
    
    function initQuickView() {
        // Implement quick view modal functionality
    }
});