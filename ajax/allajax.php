<script>
    function showToast(message) {
        const toast = $('#toast');
        toast.text(message).css('opacity', '1');

        setTimeout(() => {
            toast.css('opacity', '0');
        }, 3000);
    }
    function loadCartCount() {
        $.ajax({
            url: 'ajax/get_cart_count.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                $('#cart-count').text(res.count);
            }
        });
    }
    // loadCartCount();

    $(document).ready(function () {
        // Login AJAX
        $('#loginForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "login.php",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                }
            });
        });

    // Register AJAX
    $('#registerForm').submit(function (e) {
        e.preventDefault();
            $.ajax({
                type: "POST",
                url: "register.php",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    if (response.status === 'success') {
                        $('#tab_list_06').addClass('show active'); // Login tab
                        $('#tab_list_07').removeClass('show active'); // Register tab
                    }
                }
            });
        });
    });

    function refreshMiniCart() {
        $.ajax({
            url: 'ajax/fetch_cart.php',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $('.minicart-list').html(res.html);
                $('.minicart-item_total .ammount').text('₹' + res.subtotal);
                // Optional: Update cart icon count
                $('#cart-count').text(res.count);
            }
        });
    }
    refreshMiniCart();

    $(document).ready(function() {
        $('.ajax-add-to-cart').on('click', function(e) {
            e.preventDefault();

            if ($(this).hasClass('disabled')) {
                alert('This product is out of stock!');
                return false;
            }

            let productId = $(this).data('id');

            $.ajax({
                url: 'ajax/add_to_cart.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Product added to cart!');
                        refreshMiniCart();
                        loadCartCount();
                        // Optionally update cart count badge:
                        $('#cart-count').text(response.cart_count);
                    } else {
                        alert('Something went wrong!');
                    }
                },
                error: function() {
                    alert('Error processing request.');
                }
            });
        });
    });
    // Remove item from minicart
    $(document).on('click', '.product-item_remove', function () {
        let product_id = $(this).data('id');

        $.ajax({
            url: 'ajax/remove_from_cart.php',
            type: 'POST',
            data: { product_id: product_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showToast('Product removed from cart');
                    refreshMiniCart(); // reload minicart
                    loadCartCount();
                }
            }
        });
    });

</script>
<script>

    $(document).ready(function() {
        $(document).on('click', '#checkoutBtn', function () {
            var isLoggedIn = <?php echo isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] == true ? 'true' : 'false'; ?>;
            // console.log('Login Status:', isLoggedIn); // Debug line
            if (isLoggedIn) {
                window.location.href = 'index.php?p=checkout';
            } else {
                $('#exampleModal').modal('show');
                $("#miniCart").removeClass("open");
                $(".global-overlay").removeClass("overlay-open");
            }
        });

        $(document).on('click', '#viewCart', function () {
            var isLoggedIn = <?php echo isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] == true ? 'true' : 'false'; ?>;
            if (isLoggedIn) {
                window.location.href = 'index.php?p=cart';
            } else {
                $('#exampleModal').modal('show');
                $("#miniCart").removeClass("open");
                $(".global-overlay").removeClass("overlay-open");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem('showLogin') === '1') {
        localStorage.removeItem('showLogin'); // Clear it after use

        // Replace this with your actual modal trigger
        // Example for Bootstrap modal:
        var exampleModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        exampleModal.show();
    }
});
</script>