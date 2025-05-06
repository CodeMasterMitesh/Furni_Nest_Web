<?php
if (!isset($_SESSION['customer_logged_in'])) {
    header("Location: unauthorized.html");
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch cart items
    $sql = "SELECT products.id as product_id,cart.id as cart_id, cart.quantity, products.name, products.price, products.image 
            FROM cart 
            JOIN products ON cart.product_id = products.id 
            WHERE cart.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
?>

<div class="site-wrapper-reveal border-bottom">
    <!-- cart start -->
    <div class="cart-main-area  section-space--ptb_90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="table-content table-responsive cart-table-content header-color-gray">
                            <table>
                                <thead>
                                    <tr class="bg-gray">
                                        <th></th>
                                        <th></th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $subtotal = 0;
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        // print_r($row);
                                        $total = $row['price'] * $row['quantity'];
                                        $subtotal += $total;
                                ?>
                                    <tr data-product-id="<?php echo $row['product_id'];?>">
                                        <td></td>
                                        <td class="product-img">
                                            <a href="#"><img src="<?php echo $row['image']; ?>" alt="" style="width: 80px;"></a>
                                        </td>
                                        <td class="product-name">
                                            <a href="#" class="pid"><?php echo htmlspecialchars($row['name']); ?></a>
                                        </td>
                                        <td class="product-price">
                                            <span class="amount"><?php echo $row['price']; ?></span>
                                        </td>
                                        <td class="cart-quality">
                                            <div class="quickview-quality quality-height-dec2">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?php echo $row['quantity']; ?>" readonly>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="price-total">
                                            <span class="amount" data-amount="<?php echo (int)$total; ?>"><?php echo (int)$total; ?></span>
                                        </td>
                                        <td class="product-remove">
                                            <a class="product-item_remove" data-id="<?php echo $row['cart_id']; ?>">
                                                <i class="icon-cross2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center">Your cart is empty</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="cart-buttom-area">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="discount-code section-space--mt_60">
                                    <h6 class="mb-30">Coupon Discount</h6>
                                    <p>Enter your coupon code if you have one.</p>
                                    <input type="text" name="coupon_code" placeholder="Coupon code">
                                    <button class="coupon-btn btn btn--lg btn--border_1" type="submit">Apply coupon</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="cart_totals section-space--mt_60 ms-md-auto">
                                    <div class="grand-total-wrap">
                                        <div class="grand-total-content">
                                            <ul>
                                                <li>Subtotal <span>₹<?php echo $subtotal ?></span></li>
                                                <li>Total <span>₹<?php echo $subtotal; ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="grand-btn mt-30">
                                        <a href="index.php?p=checkout" class="btn--black btn--full text-center btn--lg">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- cart end -->
</div>

<?php include("pages/footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // When click on Increment
    $(document).on('click', '.inc', function() {
        var product_id = $(this).closest('tr').data('product-id');;
        console.log(product_id);
        var input = $(this).siblings('.cart-plus-minus-box');
        var quantity = parseInt(input.val());
        var price = $(".amount").text();
        newprice = Math.round(price);
        console.log(quantity);
        console.log(newprice);
        
        // quantity++;
        input.val(quantity);

        updateAmount(input, newprice, quantity);
        updateQuantityInDatabase(product_id, 1);
    });

    // // When click on Decrement
    $(document).on('click', '.dec', function() {
        var product_id = $(this).closest('tr').data('product-id');
        // console.log(product_id);
        var input = $(this).siblings('.cart-plus-minus-box');
        var quantity = parseInt(input.val());
        var price = $(".amount").text();
        newprice = Math.round(price);
        // console.log(price);
        // console.log(newprice);

        if (quantity > 1) {
            // quantity--;
            input.val(quantity);

            updateAmount(input, newprice, quantity);
            removeQuantityInDatabase(product_id, 1);
        }
    });

    // // Update Amount function
    function updateAmount(input, newprice, quantity) {
        var row = input.closest('tr');
        var amountField = row.find('.price-total .amount');
        var total = (newprice * quantity).toFixed(2);

        amountField.text(Math.round(total));

        updateCartTotal();
    }

    // Update Cart Subtotal and Grand Total
    function updateCartTotal() {
        var subtotal = 0;
        $('.price-total .amount').each(function() {
            var amount = parseFloat($(this).text().replace('₹', ''));
            subtotal += amount;
        });
        // Update subtotal and total
        $('.grand-total-content ul li:first-child span').text(subtotal.toFixed(2));
        $('.grand-total-content ul li:last-child span').text(subtotal.toFixed(2));
    }

    // Update Quantity in Database using Ajax
    function updateQuantityInDatabase(product_id, qty) {
        $.ajax({
            url: 'ajax/update_cart_quantity.php',
            type: 'POST',
            data: { product_id: product_id, quantity: qty },
            success: function(response) {
                refreshMiniCart();
                loadCartCount();
                // Optionally update cart count badge:
                $('#cart-count').text(response.cart_count);
            }
        });
    }

    // Update Quantity in Database using Ajax
    function removeQuantityInDatabase(product_id, qty) {
        $.ajax({
            url: 'ajax/remove_cart_quantity.php',
            type: 'POST',
            data: { product_id: product_id, quantity: qty },
            success: function(response) {
                refreshMiniCart();
                loadCartCount();
                // Optionally update cart count badge:
                $('#cart-count').text(response.cart_count);
            }
        });
    }

});
</script>