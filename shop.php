<div class="site-wrapper-reveal border-bottom">
    <!-- Product Area Start -->
    <div class="product-wrapper section-space--ptb_120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="shop-toolbar__items shop-toolbar__item--left">
                        <div class="shop-toolbar__item shop-toolbar__item--result">
                            <p class="result-count">Loading products...</p>
                        </div>

                        <div class="shop-toolbar__item shop-short-by">
                            <ul>
                                <li>
                                    <a href="#">Sort by <i class="fa fa-angle-down angle-down"></i></a>
                                    <ul>
                                        <li class="active"><a href="#" data-sort="default">Default sorting</a></li>
                                        <li><a href="#" data-sort="popularity">Sort by popularity</a></li>
                                        <li><a href="#" data-sort="rating">Sort by average rating</a></li>
                                        <li><a href="#" data-sort="latest">Sort by latest</a></li>
                                        <li><a href="#" data-sort="price_low">Sort by price: low to high</a></li>
                                        <li><a href="#" data-sort="price_high">Sort by price: high to low</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="shop-toolbar__items shop-toolbar__item--right">
                        <div class="shop-toolbar__items-wrapper">
                            <div class="shop-toolbar__item">
                                <ul class="nav toolber-tab-menu justify-content-start" role="tablist">
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_columns_01" role="tab">
                                            <img src="assets/images/svg/column-03.svg" class="img-fluid" alt="Columns 03">
                                        </a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_columns_02" role="tab"><img src="assets/images/svg/column-04.svg" class="img-fluid" alt="Columns 03"> </a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_columns_03" role="tab"><img src="assets/images/svg/column-05.svg" class="img-fluid" alt="Columns 03"> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-toolbar__item shop-toolbar__item--filter ">
                                <a class="shop-filter-active" href="#">Filter<i class="icon-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-filter-wrapper">
                <div class="row">
                    <!-- Product Filter -->
                    <div class="mb-20 col__20">
                        <div class="product-filter">
                            <h5>Color</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#"><span class="swatch-color black"></span> Black</a></li>
                                <li><a href="#"><span class="swatch-color green"></span> Green</a></li>
                                <li><a href="#"><span class="swatch-color grey"></span> Grey</a></li>
                                <li><a href="#"><span class="swatch-color red"></span> Red</a></li>
                                <li><a href="#"><span class="swatch-color white"></span> White</a></li>
                                <li><a href="#"><span class="swatch-color yellow"></span> Yellow</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Product Filter -->
                    <div class="mb-20 col__20">
                        <div class="product-filter">
                            <h5>Size</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#">Large</a></li>
                                <li><a href="#">Medium</a></li>
                                <li><a href="#">Small</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Product Filter -->
                    <div class="mb-20 col__20">
                        <div class="product-filter">
                            <h5>Price</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#" data-range="0-20">$0.00 - $20.00</a></li>
                                <li><a href="#" data-range="20-40">$20.00 - $40.00</a></li>
                                <li><a href="#" data-range="40-50">$40.00 - $50.00</a></li>
                                <li><a href="#" data-range="50-60">$50.00 - $60.00</a></li>
                                <li><a href="#" data-range="60-1000">$60.00 +</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Product Filter -->
                    <div class="mb-20 col__20">
                        <div class="product-filter">
                            <h5>Categories</h5>
                            <ul class="widget-nav-list" id="categories-filter">
                                <li><a href="#" data-id="0">All</a></li>
                                <!-- Categories will be loaded via AJAX -->
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mb-20 col__20">
                        <div class="product-filter">
                            <h5>Tags</h5>
                            <div class="tagcloud">
                                <a href="#" class="selected">All</a>
                                <a href="#" class="">Accesssories</a>
                                <a href="#" class="">Box</a>
                                <a href="#" class="">chair</a>
                                <a href="#" class="">Deco</a>
                                <a href="#" class="">Furniture</a>
                                <a href="#" class="">Glass</a>
                                <a href="#" class="">Pottery</a>
                                <a href="#" class="">Table</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab_columns_02">
                    <div class="row" id="products-container">
                        <!-- Products will be loaded here via AJAX -->
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="paginatoin-area">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="pagination-box">
                            <!-- Pagination will be loaded via AJAX -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End -->
</div>

<?php include("pages/footer.php"); ?>

<!-- Include the JavaScript file -->
<script src="assets/js/product_listing.js"></script>