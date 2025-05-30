
        <div class="site-wrapper-reveal">

            <!-- Hero Slider Area Start -->
            <div class="hero-area hero-slider-five">
                <div class="single-hero-slider-five">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hero-content-wrap">
                                    <div class="hero-text-five mt-lg-5">
                                        <h6 class=" mb-30 small-title">
                                            CHAIR <br> COLLECTION <br> 2022
                                        </h6>
                                        <h1>Chanel Chair <br> High Quality Walnut</h1>

                                        <div class="button-box section-space--mt_60">
                                            <a href="index.php?p=shop" class="text-btn-normal font-weight--reguler font-lg-p">Discover Collection <i class="icon-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="inner-images">
                                        <div class="image-one">
                                            <img src="assets/images/hero/home-full-width-2.webp" class="img-fluid" width="515" height="515" alt="Image">
                                        </div>
                                        <div class="image-two">
                                            <img src="assets/images/hero/home-full-width-4.webp" class="img-fluid" width="370" height="480" alt="Image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="single-hero-slider-five">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hero-content-wrap">
                                    <div class="hero-text-five mt-lg-5">
                                        <h6 class=" mb-30 small-title">
                                            CHAIR <br> COLLECTION <br> 2022
                                        </h6>
                                        <h1>Flower Vase <br>  Made Of Ceramic</h1>

                                        <div class="button-box section-space--mt_60">
                                            <a href="index.php?p=shop" class="text-btn-normal font-weight--reguler font-lg-p">Discover Collection <i class="icon-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="inner-images">
                                        <div class="image-one">
                                            <img src="assets/images/hero/home-full-width-2.webp" class="img-fluid" width="515" height="515" alt="Image">
                                        </div>
                                        <div class="image-two">
                                            <img src="assets/images/hero/home-full-width-1.webp" class="img-fluid" width="597" height="407" alt="Image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <!-- Hero Slider Area End -->

            <!-- Banner Area Start -->
            <div class="banner-area-box">
                <div class="container">
                    <div class="row banner-inner-box">
                        <div class="col-lg-6 col-md-6">
                            <div class="banner-images-one mt-30">
                                <a href="#" class="thumbnail">
                                    <img src="assets/images/banners/bn-hf-1-570x340.webp" width="546" height="326" class="img-fluid" alt="Banner images">
                                </a>
                                <div class="banner-title">
                                    <h3><a href="#">Table collection </a></h3>
                                    <h6>Furniture Helen</h6>
                                    <div class="button-box mt-40">
                                        <a href="#" class="text-btn-normal">Discover now <i class="icon-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="banner-images-one mt-30">
                                <a href="#" class="thumbnail">
                                    <img src="assets/images/banners/bn-hf-2-570x340.webp" width="546" height="326" class="img-fluid" alt="Banner images">
                                </a>
                                <div class="banner-title">
                                    <h3><a href="#">Chair collection </a></h3>
                                    <h6>Furniture Helen</h6>
                                    <div class="button-box mt-40">
                                        <a href="#" class="text-btn-normal">Discover now <i class="icon-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner Area End -->


            <!-- Product Area Start -->
            <div class="product-wrapper section-space--ptb_120">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="section-title text-lg-start text-center mb-20">
                                <h3 class="section-title">New products</h3>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <?php 
                                $categories = getRows("categories");
                                ?>
                            <ul class="nav product-tab-menu justify-content-lg-end justify-content-center" role="tablist">
                                <li class="tab__item nav-item active">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_all" role="tab">All Products</a>
                                </li>
                                <?php foreach ($categories as $index => $cat): ?>
                                <li class="tab__item nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_<?= $cat['id'] ?>" role="tab"><?= $cat['name'] ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content mt-30">
                        <div class="tab-pane fade show active" id="tab_all">
                            <!-- product-slider-active -->
                            <div class="product-slider-active">
                                <!-- Single Product Item Start -->
                                <?php
                                        $products = getRows("products");
                                        foreach($products as $index => $product) {
                                        ?>
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
                                                <span class="new-price">₹<?php echo number_format($product['price'], 2) ?></span>
                                                <?php if ($product['old_price'] > 0): ?>
                                                    - <span class="old-price">₹<?= number_format($product['old_price'], 2) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                ?>
                                <!-- Single Product Item End -->
                            </div>
                        </div>
                        <?php foreach ($categories as $cat): ?>
                        <div class="tab-pane fade" id="tab_<?= $cat['id'] ?>">
                            <div class="product-slider-active">
                                <?php
                                $cat_id = $cat['id'];
                                $product_query = getRows("products");
                                foreach($product_query as $index => $product) {
                                    include 'product-card.php';
                                }
                                ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Product Area End -->

            <!-- Offer Colection Area Start -->
            <div class="offer-colection-area">
                <div class="section-space--ptb_120 bg-img" data-bg="assets/images/bg/banner_large.webp">
                    <div class="container">
                        <div class="row">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 col-md-9">
                                        <div class="colection-info-wrap">
                                            <div class="section-title mb-10">
                                                <h2 class="h-lg"><span class="text-red">50% OFF</span> Interior Collection</h2>
                                            </div>
                                            <p class="font-lg-p">Free shipping over $125 for international orders</p>
                                            <div class="button-box section-space--mt_60">
                                                <a href="index.php?p=shop" class="text-btn-normal font-weight--bold font-lg-p">Discover now <i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Offer Colection Area End -->


            <!-- Product Area Start -->
            <div class="product-wrapper section-space--ptb_120">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="section-title text-lg-start text-center mb-20">
                                <h3 class="section-title">Best selling</h3>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <ul class="nav product-tab-menu justify-content-lg-end justify-content-center" role="tablist">
                                <li class="tab__item nav-item active">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_11" role="tab">All Products</a>
                                </li>
                                <?php foreach ($categories as $index => $cat): ?>
                                <li class="tab__item nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_<?= $cat['id'] ?>" role="tab"><?= $cat['name'] ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                    <div class="tab-content mt-30">
                        <div class="tab-pane fade show active" id="tab_list_11">
                            <!-- product-slider-active -->
                            <div class="row">
                            <?php
                                    foreach($products as $index => $product){
                                        ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6">
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
                                                <span class="new-price">₹<?php echo number_format($product['price'], 2) ?></span>
                                                <?php if ($product['old_price'] > 0): ?>
                                                    - <span class="old-price">₹<?= number_format($product['old_price'], 2) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <?php
                                    }
                                    // exit;
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Product Area End -->


            <!-- Our Blog Area Start -->
            <div class="our-blog-area section-space--pb_90">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="section-title text-start mb-20">
                                <h2 class="section-title">Latest from our blog</h2>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="text-btn-normal">Discover now <i class="icon-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <!-- Single Blog Item Start -->
                            <div class="single-blog-item mt-30">
                                <div class="blog-thumbnail-box">
                                    <a href="#" class="thumbnail">
                                        <img src="assets/images/blog/8-570x370.webp" class="img-fluid" alt="Blog Images">
                                    </a>
                                    <a href="#" class="btn-blog"> Read more </a>
                                </div>
                                <div class="blog-contents">
                                    <h6 class="blog-title"><a href="#">Interior design is the art, the interior designer is the artist.</a></h6>
                                    <div class="meta-tag-box">
                                        <div class="meta date"><span>October 15, 2022</span></div>
                                        <div class="meta author"><span><a href="#">Hastheme</a></span></div>
                                        <div class="meta cat"><span>in <a href="#">Chair</a></span></div>
                                    </div>
                                </div>
                            </div><!-- Single Blog Item End -->
                        </div>
                        <div class="col-lg-4 col-md-6  col-sm-6 col-12">
                            <!-- Single Blog Item Start -->
                            <div class="single-blog-item mt-30">
                                <div class="blog-thumbnail-box">
                                    <a href="#" class="thumbnail">
                                        <img src="assets/images/blog/9-570x370.webp" class="img-fluid" alt="Blog Images">
                                    </a>
                                    <a href="#" class="btn-blog"> Read more </a>
                                </div>
                                <div class="blog-contents">
                                    <h6 class="blog-title"><a href="#">Decorate your home with the most modern furnishings.</a></h6>
                                    <div class="meta-tag-box">
                                        <div class="meta date"><span>October 02, 2022</span></div>
                                        <div class="meta author"><span><a href="#">Hastheme</a></span></div>
                                        <div class="meta cat"><span>in <a href="#">Chair</a></span></div>
                                    </div>
                                </div>
                            </div><!-- Single Blog Item End -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <!-- Single Blog Item Start -->
                            <div class="single-blog-item mt-30">
                                <div class="blog-thumbnail-box">
                                    <a href="#" class="thumbnail">
                                        <img src="assets/images/blog/10-570x370.webp" class="img-fluid" alt="Blog Images">
                                    </a>
                                    <a href="#" class="btn-blog"> Read more </a>
                                </div>
                                <div class="blog-contents">
                                    <h6 class="blog-title"><a href="#">Spatialize with the decorations of the FurniNest store.</a></h6>
                                    <div class="meta-tag-box">
                                        <div class="meta date"><span>October 18, 2022</span></div>
                                        <div class="meta author"><span><a href="#">Hastheme</a></span></div>
                                        <div class="meta cat"><span>in <a href="#">Chair</a></span></div>
                                    </div>
                                </div>
                            </div><!-- Single Blog Item End -->
                        </div>
                    </div>

                </div>
            </div>
            <!-- Our Blog Area End -->


            <!-- Our Brand Area Start -->
            <div class="our-brand-area section-space--pb_90">
                <div class="container">
                    <div class="brand-slider-active">
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner1.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner2.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner3.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner4.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner5.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-brand-item">
                                <a href="#"><img src="assets/images/brand/partner3.webp" class="img-fluid" alt="Brand Images"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Our Brand Area End -->

        </div>
        <!--====================  footer area ====================-->
        <div class="footer-area-wrapper reveal-footer bg-gray">
            <div class="footer-area section-space--ptb_90">
                <div class="container-fluid container-fluid--cp-100">
                    <div class="row footer-widget-wrapper">
                        <div class="col-lg-3 col-md-3 col-sm-6 footer-widget">
                            <div class="footer-widget__logo mb-20">
                                <a href="#"><img class="w-100" src="assets/images/logo/logo.svg" alt=""></a>
                            </div>
                            <ul class="footer-widget__list">
                                <li><i class="icon_pin"></i> FurniNest, Ahmedabad,Gujarat,382345</li>
                                <li> <i class="icon_phone"></i><a href="tel:846677028028" class="hover-style-link">+846677028028</a></li>

                            </ul>
                            <ul class="list footer-social-networks mt-25">

                                <li class="item">
                                    <a href="https://twitter.com/" target="_blank" aria-label="Twitter">
                                        <i class="social social_facebook"></i>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="https://facebook.com/" target="_blank" aria-label="Facebook">
                                        <i class="social social_twitter"></i>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="https://instagram.com/" target="_blank" aria-label="Instagram">
                                        <i class="social social_tumblr"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-4 col-sm-6 footer-widget">
                            <h6 class="footer-widget__title mb-20">Quick Link</h6>
                            <ul class="footer-widget__list">
                                <li><a href="#" class="hover-style-link">About Us</a></li>
                                <li><a href="#" class="hover-style-link">What We Do</a></li>
                                <li><a href="#" class="hover-style-link">FAQ Page</a></li>
                                <li><a href="#" class="hover-style-link">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-6 footer-widget">
                            <h6 class="footer-widget__title mb-20">Instagram</h6>
                            <div id="instagramFeed"></div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 footer-widget">
                            <h6 class="footer-widget__title mb-20">Newsletter</h6>
                            <div class="footer-widget__newsletter mt-30">
                                <input type="text" placeholder="Your email address">
                                <button class="submit-button"><i class="icon-arrow-right"></i></button>
                            </div>
                            <ul class="footer-widget__footer-menu  section-space--mt_60 d-none d-lg-block">
                                <li><a href="#">Term & Condition</a></li>
                                <li><a href="#">Policy</a></li>
                                <li><a href="#">Map</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="footer-copyright-area section-space--ptb_30">
                <div class="container-fluid container-fluid--cp-100">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <span class="copyright-text text-center text-md-start">&copy; 2023 FurniNest. <a  href="https://hasthemes.com/" target="_blank">All Rights Reserved.</a></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--====================  End of footer area  ====================-->
    <?php include("pages/footer.php");  ?>