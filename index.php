<?php 
include('config/conn.php');
if(!isset($_SESSION['customer_logged_in'])){
    $_SESSION['customer_logged_in'] = false;
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FurniNest &#8211; Minimalis Furniture eCommerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico">

    <!-- CSS============================================ -->

    <link rel="stylesheet" href="assets/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="assets/css/plugins/plugins.min.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <style>
        @media screen and (max-width: 426px) {
            .hcenter {
                justify-content:center !important;
            }
            
        }
        @media screen and (min-width: 426px) and (max-width: 768px) {
            .mmenu{
                display: block !important;
            }
            
        }
        
    </style>
</head>
<body class="">
<div id="toast" style="position: fixed; bottom: 30px; right: 30px; background-color: #333; color: #fff; padding: 10px 20px; border-radius: 4px; opacity: 0; transition: opacity 0.5s; z-index: 9999;"></div>
    <!--====================  header area ====================-->
    <div class="header-area header-area--default">

        <!-- Header Bottom Wrap Start -->
        <header class="header-area header_absolute header_height-90 header-sticky">
            <div class="container-fluid container-fluid--cp-100">
                <div class="row align-items-center">

                    <div class="col-lg-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="logo text-start">
                            <a href="#"><img class="w-100" src="assets/images/logo/logo.svg" alt=""></a>
                            <!-- <a class="navbar-brand fs-3" href="dashboard.php">FurniNest</a> -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-lg-6  d-none d-lg-block">
                        <div class="header__navigation d-none d-lg-block">
                            <nav class="navigation-menu">
                                <ul class="justify-content-center">
                                    <li class="has-children has-children--multilevel-submenu">
                                        <a href="/"><span>Home</span></a>
                                    </li>
                                    <li class="has-children">
                                        <a href="index.php?p=shop"><span>Shop</span></a>
                                    </li>
                                    <li class="has-children has-children--multilevel-submenu">
                                        <a href="index.php?p=about-us"><span>About Us</span></a>
                                    </li>
                                    <li class="has-children has-children--multilevel-submenu">
                                        <a href="index.php?p=contact-us"><span>Contact Us</span></a>
                                    </li>
                                    <li class="has-children has-children--multilevel-submenu">
                                        <a href="index.php?p=blog-grid"><span>Blog</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="header-right-side align-items-center hcenter text-end">
                            <?php
                            if($_SESSION['customer_logged_in']){
                                 if(isset($_SESSION['user_id'])){
                                    $user_id = $_SESSION['user_id'];
                                    $users = getRows("users","id=$user_id","");
                                    foreach($users as $u){
                                        $user = $u;
                                    }
                                    echo '<a href="index.php?p=my-account" class="header-cart">Welcome '.$user['username'].'</a>';
                                } 
                            }else{
                                echo '<div class="header-right-items d-none d-md-block">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="icon-user"></i>
                                    </a>
                                </div>';
                            }?>
                            <div class="header-right-items d-none d-md-block">
                                <a href="index.php?p=wishlist" class="header-cart">
                                    <i class="icon-heart"></i>
                                    <span class="item-counter">3</span>
                                </a>
                            </div>

                            <div class="header-right-items">
                                <a href="#miniCart" class=" header-cart minicart-btn toolbar-btn header-icon">
                                    <i class="icon-bag2"></i>
                                    <span class="item-counter" id="cart-count"></span>
                                </a>
                            </div>
                            <div class="header-right-items d-block d-md-none">
                                <a href="javascript:void(0)" class="search-icon" id="search-overlay-trigger">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </div>
                            <div class="header-right-items mmenu d-none">
                                <a href="javascript:void(0)" class="mobile-navigation-icon" id="mobile-menu-trigger">
                                    <i class="icon-menu"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header Bottom Wrap End -->
    </div>
    <!--====================  End of header area  ====================-->
    <div id="main-wrapper">
    <?php
    $protected_pages = ['my-account', 'cart', 'checkout'];

        if (isset($_GET['p'])) {
            $page = basename($_GET['p']);
            // echo $page;
            // Check if the page is protected
            if (in_array($page, $protected_pages) && !isset($_SESSION['customer_logged_in'])) {
                header("Location: unauthorized.html");
                exit;
            }

            // If file exists, include it safely
            $file = $page . '.php';
            if (file_exists($file)) {
                include_once($file);
            } else {
                echo "Page not found.";
            }
        } else {
            include_once('home.php');
        }
        ?>
    
    </div>

    <!-- Modal -->
    <div class="product-modal-box modal fade" id="prodect-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span class="icon-cross" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="quickview-product-active mr-lg-5">
                                <a href="#" class="images">
                                    <img src="assets/images/product/2-570x570.webp" class="img-fluid" alt="">
                                </a>
                                <a href="#" class="images">
                                    <img src="assets/images/product/3-600x600.webp" class="img-fluid" alt="">
                                </a>
                                <a href="#" class="images">
                                    <img src="assets/images/product/4-768x768.webp" class="img-fluid" alt="">
                                </a>
                            </div>
                            <!-- Thumbnail Large Image End -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content-wrap ">

                                <h5 class="font-weight--reguler mb-10">Teapot with black tea</h5>
                                <div class="quickview-ratting-review mb-10">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                        </div>
                                        <a href="#"> 2 customer review</a>
                                    </div>
                                </div>
                                <h3 class="price">£59.99</h3>

                                <div class="stock in-stock mt-10">
                                    <p>Available: <span>In stock</span></p>
                                </div>

                                <div class="quickview-peragraph mt-10">
                                    <p>At vero accusamus et iusto odio dignissimos blanditiis praesentiums dolores molest.</p>
                                </div>


                                <div class="quickview-action-wrap mt-30">
                                    <div class="quickview-cart-box">
                                        <div class="quickview-quality">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="0">
                                            </div>
                                        </div>

                                        <div class="quickview-button">
                                            <div class="quickview-cart button">
                                                <a href="index.php?p=product-details" class="btn--lg btn--black font-weight--reguler text-white">Add to cart</a>
                                            </div>
                                            <div class="quickview-wishlist button">
                                                <a title="Add to wishlist" href="#"><i class="icon-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="product_meta mt-30">
                                    <div class="sku_wrapper item_meta">
                                        <span class="label"> SKU: </span>
                                        <span class="sku"> 502 </span>
                                    </div>
                                    <div class="posted_in item_meta">
                                        <span class="label">Categories: </span><a href="#">Furniture</a>, <a href="#">Table</a>
                                    </div>
                                    <div class="tagged_as item_meta">
                                        <span class="label">Tag: </span><a href="#">Pottery</a>
                                    </div>
                                </div>

                                <div class="product_socials section-space--mt_60">
                                    <span class="label">Share this items :</span>
                                    <ul class="furninest-social-share socials-inline">
                                        <li>
                                            <a class="share-twitter furninest-twitter" href="#" target="_blank"><i class="social_twitter"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-facebook furninest-facebook" href="#" target="_blank"><i class="social_facebook"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-google-plus furninest-google-plus" href="#" target="_blank"><i class="social_googleplus"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-pinterest furninest-pinterest" href="#" target="_blank"><i class="social_pinterest"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-linkedin furninest-linkedin" href="#" target="_blank"><i class="social_linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!-- Modal -->
    <div class="header-login-register-wrapper modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-box-wrapper">
                    <div class="furninest-tabs">
                        <ul class="nav" role="tablist">
                            <li class="tab__item nav-item active">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_06" role="tab">Login</a>
                            </li>
                            <li class="tab__item nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_list_07" role="tab">Our Register</a>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content content-modal-box">
                        <div class="tab-pane fade show active" id="tab_list_06" role="tabpanel">
                            <form id="loginForm" method="POST" class="account-form-box">
                                <h6>Login your account</h6>
                                <div class="single-input">
                                    <input type="text" name="username" placeholder="Username or Email" required>
                                </div>
                                <div class="single-input">
                                    <input type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="checkbox-wrap mt-10">
                                    <label class="label-for-checkbox inline mt-15">
                                        <input class="input-checkbox" type="checkbox" id="rememberme" name="rememberme"> <span>Remember me</span>
                                    </label>
                                </div>
                                <div class="button-box mt-25">
                                    <button type="submit" class="btn btn--full btn--black">Log in</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab_list_07" role="tabpanel">

                            <form id="registerForm" method="POST" class="account-form-box">
                                <h6>Register An Account</h6>
                                <div class="single-input">
                                    <input type="text" name="username" placeholder="Username" required>
                                </div>
                                <div class="single-input">
                                    <input type="email" name="email" placeholder="Email address" required>
                                </div>
                                <div class="single-input">
                                    <input type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="button-box mt-25">
                                    <button type="submit" class="btn btn--full btn--black">Register</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="header-login-register-wrapper modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-box-wrapper">
                    <div class="furninest-tabs">
                        <ul class="nav" role="tablist">
                            <li class="tab__item nav-item active">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_06" role="tab">Login</a>
                            </li>
                            <li class="tab__item nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_list_07" role="tab">Our Register</a>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content content-modal-box">
                        <div class="tab-pane fade show active" id="tab_list_06" role="tabpanel">
                            <form action="#" class="account-form-box">
                                <h6>Login your account</h6>
                                <div class="single-input">
                                    <input type="text" placeholder="Username">
                                </div>
                                <div class="single-input">
                                    <input type="password" placeholder="Password">
                                </div>
                                <div class="checkbox-wrap mt-10">
                                    <label class="label-for-checkbox inline mt-15">
                                        <input class="input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>Remember me</span>
                                    </label>
                                    <a href="#" class=" mt-10">Lost your password?</a>
                                </div>
                                <div class="button-box mt-25">
                                    <a href="#" class="btn btn--full btn--black">Log in</a>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab_list_07" role="tabpanel">

                            <form action="#" class="account-form-box">
                                <h6>Register An Account</h6>
                                <div class="single-input">
                                    <input type="text" placeholder="Username">
                                </div>
                                <div class="single-input">
                                    <input type="text" placeholder="Email address">
                                </div>
                                <div class="single-input">
                                    <input type="password" placeholder="Password">
                                </div>
                                <p class="mt-15">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="privacy-policy-link" target="_blank">privacy policy</a>.</p>
                                <div class="button-box mt-25">
                                    <a href="#" class="btn btn--full btn--black">Register</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====================  mobile menu overlay ====================-->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay">
        <div class="mobile-menu-overlay__inner">
            <div class="mobile-menu-close-box text-start">
                <span class="mobile-navigation-close-icon" id="mobile-menu-close-trigger"> <i class="icon-cross2"></i></span>
            </div>
            <div class="mobile-menu-overlay__body">
                <div class="offcanvas-menu-header d-md-block d-none">
                    <div class="furninest-language-currency row-flex row section-space--mb_60 ">
                        <div class="widget-language col-md-6">
                            <h6> Language</h6>
                            <ul>
                                <li class="actived"> <a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">Arabric</a></li>
                            </ul>
                        </div>
                        <div class="widget-currency col-md-6">
                            <h6> Currencies</h6>
                            <ul>
                                <li class="actived"><a href="#">USD - US Dollar</a></li>
                                <li><a href="#">Euro</a></li>
                                <li><a href="#">Pround</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <nav class="offcanvas-navigation">
                    <ul>
                        <li class="has-children">
                            <a href="#">Home</a>
                            <ul class="sub-menu">
                                <li><a href="index.php"><span>Home V1 – Default</span></a></li>
                                <!-- <li><a href="index-7.php"><span>Home V2 – Boxed</span></a></li>
                                <li><a href="index-8.php"><span>Home V3 – Carousel</span></a></li>
                                <li><a href="index-11.php"><span>Home V4 – Categories</span></a></li>
                                <li><a href="index-10.php"><span>Home V5 – Collection</span></a></li>
                                <li><a href="index-5.php"><span>Home V6 – Full Width</span></a></li>
                                <li><a href="index-4.php"><span>Home V7 – Left Sidebar</span></a></li>
                                <li><a href="index-3.php"><span>Home V8 – Metro</span></a></li>
                                <li><a href="index-2.php"><span>Home V9 – Minimal</span></a></li>
                                <li><a href="index-6.php"><span>Home V10 – Parallax</span></a></li>
                                <li><a href="index-12.php"><span>Home V11 – Video Feature</span></a></li>
                                <li><a href="index-9.php"><span>Home V12 – 02 Feature</span></a></li>
                                <li><a href="index-13.php"><span>Home V13 – 03 Feature</span></a></li> -->
                            </ul>
                        </li>
                        <li class="has-children">
                            <a href="#">Shop</a>
                            <ul class="sub-menu">
                                <li class="has-children">
                                    <a href="#"><span>Shop Pages</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="index.php?p=shop-3-column"><span>Shop 3 Columns</span></a></li>
                                        <li><a href="index.php?p=shop"><span>Shop 4 Columns</span></a></li>
                                        <li><a href="index.php?p=shop-5-column"><span>Shop 5 Columns</span></a></li>
                                        <li><a href="index.php?p=shop-6-column"><span>Shop 6 Columns</span></a></li>
                                        <li><a href="index.php?p=shop-categories"><span>Shop Categories</span></a></li>
                                        <li><a href="index.php?p=shop-carousel"><span>Shop Carousel</span></a></li>
                                        <li><a href="index.php?p=shop-with-boder"><span>Shop With Border</span></a></li>
                                        <li><a href="index.php?p=shop-left-sidebar"><span>Shop Left Sidebar</span></a></li>
                                        <li><a href="index.php?p=shop-right-sidebar"><span>Shop Right Sidebar</span></a></li>
                                        <li><a href="index.php?p=shop-without-gutter"><span>Shop Without Gutter</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><span>Product Pages</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="index.php?p=product-details"><span>Default</span></a></li>
                                        <li><a href="index.php?p=product-simple"><span>Simple</span></a></li>
                                        <li><a href="index.php?p=product-variable"><span>Variable</span></a></li>
                                        <li><a href="index.php?p=product-groupped"><span>Groupped</span></a></li>
                                        <li><a href="index.php?p=product-on-sale"><span>On Sale</span></a></li>
                                        <li><a href="index.php?p=product-out-of-stock"><span>Out Of Stock</span></a></li>
                                        <li><a href="index.php?p=product-affiliate"><span>Affiliate</span></a></li>
                                        <li><a href="index.php?p=product-image-swatches"><span>Image Swatches</span></a></li>
                                        <li><a href="index.php?p=product-countdown-timer"><span>With Countdown Timer</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><span>Other Pages</span></a>
                                    <ul class="sub-menu">
                                        <li><a id="viewCart"><span>Cart</span></a></li>
                                        <li><a id="checkoutBtn"><span>Checkout</span></a></li>
                                        <li><a href="index.php?p=my-account"><span>My Account</span></a></li>
                                        <li><a href="index?p=wishlist"><span>Wishlist</span></a></li>
                                        <li><a href="index.php?p=order-tracking"><span>Order Tracking</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-children">
                            <a href="#">Pages</a>
                            <ul class="sub-menu">
                                <li><a href="index.php?p=about-us"><span>About Us</span></a></li>
                                <li><a href="index.php?p=contact-us"><span>Contact</span></a></li>
                                <li><a href="index.php?p=faq"><span>FAQ Pages</span></a></li>
                                <li><a href="index.php?p=coming-soon"><span>Coming Soon</span></a></li>
                                <li><a href="index.php?p=404-page"><span>404 Page</span></a></li>
                            </ul>
                        </li>
                        <li class="has-children">
                            <a href="javascript:void(0)">Blog</a>
                            <ul class="sub-menu">
                                <li><a href="index.php?p=blog-grid"><span>Blog Grid</span></a></li>
                                <li><a href="index.php?p=blog-listing"><span>Blog List</span></a></li>
                                <li><a href="index.php?p=blog-masonry"><span>Blog Masonry</span></a></li>
                                <li><a href="index.php?p=blog-left-sidebar"><span>Blog Sidebar</span></a></li>
                                <li><a href="index.php?p=single-blog-post"><span>Single Post V1</span></a></li>
                                <li><a href="index.php?p=single-blog-post-2"><span>Single Post V2</span></a></li>
                            </ul>
                        </li>

                    </ul>
                </nav>

                <div class="mobile-menu-contact-info section-space--mt_60">
                    <h6>Contact Us</h6>
                    <p>69 Halsey St, Ny 10002, New York, United States <br>support.center@unero.co <br>(0091) 8547 632521</p>
                </div>

                <div class="mobile-menu-social-share section-space--mt_60">
                    <h6>Follow US On Socials</h6>
                    <ul class="social-share">
                        <li><a href="#"><i class="social social_facebook"></i></a></li>
                        <li><a href="#"><i class="social social_twitter"></i></a></li>
                        <li><a href="#"><i class="social social_googleplus"></i></a></li>
                        <li><a href="#"><i class="social social_linkedin"></i></a></li>
                        <li><a href="#"><i class="social social_pinterest"></i></a></li>
                    </ul>
                </div>


            </div>


        </div>


    </div>
    <!--====================  End of mobile menu overlay  ====================-->



    <!--  offcanvas Minicart Start -->
    <div class="offcanvas-minicart_wrapper" id="miniCart">
        <div class="offcanvas-menu-inner">
            <div class="close-btn-box">
                <a href="#" class="btn-close"><i class="icon-cross2"></i></a>
            </div>
            <div class="minicart-content">
                <ul class="minicart-list"></ul>
            </div>
            <div class="minicart-item_total">
                <span class="font-weight--reguler">Subtotal:</span>
                <span class="ammount font-weight--reguler">$60.00</span>
            </div>
            <div class="minicart-btn_area">
                <a id="viewCart"  class="btn btn--full btn--border_1">View cart</a>
            </div>
            <div class="minicart-btn_area mcart">
                <a id="checkoutBtn" class="btn btn--full btn--black">Checkout</a>
            </div>
        </div>

        <div class="global-overlay"></div>
    </div>
    <!--  offcanvas Minicart End -->


    <!--====================  search overlay ====================-->
    <div class="search-overlay" id="search-overlay">

        <div class="search-overlay__header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-8">
                        <div class="search-title">
                            <h4 class="font-weight--normal">Search</h4>
                        </div>
                    </div>
                    <div class="col-md-6 ms-auto col-4">
                        <!-- search content -->
                        <div class="search-content text-end">
                            <span class="mobile-navigation-close-icon" id="search-close-trigger"><i class="icon-cross"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-overlay__inner">
            <div class="search-overlay__body">
                <div class="search-overlay__form">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9 m-auto">
                                <form action="#">
                                    <div class="product-cats section-space--mb_60 text-center">
                                        <label> <input type="radio" name="product_cat" value="" checked="checked"> <span class="line-hover">All</span> </label>
                                        <label> <input type="radio" name="product_cat" value="decoration"> <span class="line-hover">Decoration</span> </label>
                                        <label> <input type="radio" name="product_cat" value="furniture"> <span class="line-hover">Furniture</span> </label>
                                        <label> <input type="radio" name="product_cat" value="table"> <span class="line-hover">Table</span> </label> <label> <input type="radio" name="product_cat" value="chair"> <span class="line-hover">Chair</span> </label>
                                    </div>
                                    <div class="search-fields">
                                        <input type="text" placeholder="Search">
                                        <button class="submit-button"><i class="icon-magnifier"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--====================  End of search overlay  ====================-->


    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top icon-arrow-up"></i>
        <i class="arrow-bottom icon-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->



    <!-- JS
    ============================================ -->
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load performance and remove plugin js files from avobe) -->

    <script src="assets/js/plugins/plugins.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include 'ajax/allajax.php'; ?>

</body>
</html>