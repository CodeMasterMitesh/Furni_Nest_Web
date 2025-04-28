<?php
$user_id = $_SESSION['user_id'];

// Fetch cart items
$sql = "SELECT products.id as product_id,cart.id as cart_id, cart.quantity, products.name, products.price, products.image 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

?>
<div class="site-wrapper-reveal border-bottom">
    <!-- checkout start -->
    <div class="checkout-main-area section-space--ptb_90">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="customer-zone mb-30">
                        <p class="cart-page-title">Returning customer? <a class="checkout-click-login" href="#"> Click here to login</a></p>
                        <div class="checkout-login-info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                            <form action="#" class="account-form-box">
                                <div class="single-input mt-20">
                                    <label>Username or email <span class="required">*</span></label>
                                    <input type="email">
                                </div>
                                <div class="single-input mt-20">
                                    <label>Password <span class="required">*</span></label>
                                    <input type="password" placeholder="Password">
                                </div>
                                <div class="checkbox-wrap mt-10">
                                    <label class="label-for-checkbox inline mt-15">
                                        <input class="input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>Remember me</span>
                                    </label>
                                </div>
                                <div class="button-box mt-15">
                                    <a href="#" class="btn btn--lg btn--black">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="customer-zone mb-30">
                        <p class="cart-page-title">Have a coupon? <a class="checkout-click" href="#">Click here to enter your code</a></p>
                        <div class="checkout-coupon-info">
                            <p>If you have a coupon code, please apply it below.</p>
                            <form action="#">
                                <input type="text" placeholder="Coupon code">
                                <input type="submit" value="Apply Coupon">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        <form id="placeOrder" method="POST">
            <div class="checkout-wrap">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-100">
                            <h6 class="mb-20">Billing Details</h6>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-25">
                                        <label>First name <span class="required" title="required">*</span></label>
                                        <input type="text" name="first_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-25">
                                        <label>Last name <span class="required" title="required">*</span></label>
                                        <input type="text" name="last_name">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-25">
                                        <label>Home/Office <span class="required" title="required">*</span></label>
                                        <input type="text" name="type">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-select mb-25">
                                        <label>Country <span class="required" title="required">*</span></label>
                                        <select class="select-active" name="country">
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-25">
                                        <label>Street address <span class="required" title="required">*</span></label>
                                        <input class="billing-address" name="address_line1" placeholder="House number and street name" type="text">
                                        <input name="address_line2" placeholder="Apartment, suite, unit etc. (optional)" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-25">
                                        <label>Town / City <span class="required" title="required">*</span></label>
                                        <input type="text" name="city">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-select mb-25">
                                        <label>State <span class="required" title="required">*</span></label>
                                        <select class="select-active" name="state">
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="MP">MP</option>
                                            <option value="UP">UP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label>Postcode / ZIP (optional) <span class="required" title="required">*</span></label>
                                        <input type="text" name="postal_code">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label>Phone <span class="required" title="required">*</span></label>
                                        <input type="text" name="phone">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-25">
                                        <label>Email Address <span class="required" title="required">*</span></label>
                                        <input type="text" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="additional-info-wrap">
                                <h6 class="mb-10">Additional information</h6>
                                <label>Order notes (optional)</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="your-order-wrappwer tablet-mt__60 small-mt__60">
                            <h6 class="mb-20">Your order</h6>
                            <div class="your-order-area">
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li>Product <span>Total</span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <ul>
                                            <?php
                                                $subtotal = 0;
                                                if(mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        // print_r($row);
                                                        $total = $row['price'] * $row['quantity'];
                                                        $subtotal += $total;
                                                ?>
                                                <li><?php echo $row['name'] ?> X <?php echo $row['quantity'] ?> <span><?php echo $subtotal ?> </span></li>
                                                <?php } } ?>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li><strong>Subtotal</strong> <span><?php echo $subtotal ?> </span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li><strong>Total</strong> <span><?php echo $subtotal ?> </span></li>
                                            </ul>
                                        </div>

                                        <div class="payment-area mt-30">
                                            <div class="single-payment">
                                                <h6 class="mb-10">Check payments</h6>
                                                <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                            </div>
                                            <div class="single-payment mt-20">
                                                <h6 class="mb-10">What is PayPal?</h6>
                                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="payment-method">

                                <p class="mt-30">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">privacy policy</a>.</p>
                            </div>
                            <div class="place-order mt-30">
                                <button type="submit" class="btn btn--full btn--black text-center">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- checkout end -->
</div>
<?php include("pages/footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $('#placeOrder').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "ajax/order_success.php",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        // location.reload();
                    }
                }
            });
        });
    });
</script>