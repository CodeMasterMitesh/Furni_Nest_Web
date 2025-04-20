<div class="single-product-item text-center">
    <div class="products-images">
        <a href="index.php?p=product-details&id=<?= $product['id'] ?>" class="product-thumbnail">
            <img src="<?= $product['image'] ?>" class="img-fluid" width="300" height="300" alt="<?= $product['name'] ?>">
            <?php if ($product['stock_status'] == 'out_of_stock'): ?>
                <span class="ribbon out-of-stock">Out Of Stock</span>
            <?php elseif ($product['discount'] > 0): ?>
                <span class="ribbon onsale">-<?= $product['discount'] ?>%</span>
            <?php endif; ?>
        </a>
        <div class="product-actions">
            <a href="#" data-bs-toggle="modal" data-bs-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
            <a href="#" class="ajax-add-to-cart <?= $product['stock_status'] == 'out_of_stock' ? 'disabled' : '' ?>" data-id="<?= $product['id'] ?>">
                <i class="p-icon icon-bag2"></i> 
                <span class="tool-tip">Add to cart</span>
            </a>
            <a href="index.php?p=wishlist"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
        </div>
    </div>
    <div class="product-content">
        <h6 class="prodect-title"><a href="index.php?p=product-details&id=<?= $product['id'] ?>"><?= $product['name'] ?></a></h6>
        <div class="prodect-price">
            <span class="new-price">₹<?= number_format($product['price'], 2) ?></span>
            <?php if ($product['old_price'] > 0): ?>
                - <span class="old-price">₹<?= number_format($product['old_price'], 2) ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>