
<?php
if (!isset($_SESSION['customer_logged_in'])) {
    header("Location: unauthorized.html");
    exit;
}
if($_SESSION['customer_logged_in']){
$user_id = $_SESSION['user_id']; 
}
?>
<div class="site-wrapper-reveal border-bottom">
    <div class="my-account-page-warpper section-space--ptb_120">
        <div class="container">
            <div class="row">
                <div class="col">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <div class="row">

                            <!-- My Account Tab Menu Start -->
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a>
                                    <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment Method</a>
                                    <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                                    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong><?php echo $_SESSION['customer_data']['first_name']?></strong> (If Not <strong><?php echo $_SESSION['customer_data']['first_name']?> !</strong><a href="index.php?p=logout" class="logout"> Logout</a>)</p>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                    $order_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
                                                    $order_result = mysqli_query($conn, $order_query);

                                                    if (mysqli_num_rows($order_result) > 0) {
                                                        while ($order = mysqli_fetch_assoc($order_result)) {
                                                            $order_id = $order['id'];
                                                            $order_number = $order['order_number'];
                                                            $created_at = date('M d, Y', strtotime($order['created_at']));
                                                            $status = $order['status'];
                                                            $total_price = $order['total_price'];
                                                            ?>
                                                            <tr>
                                                                <td>#<?php echo $order_number; ?></td>
                                                                <td><?php echo $created_at; ?></td>
                                                                <td><?php echo $status; ?></td>
                                                                <td>₹<?php echo number_format($total_price, 2); ?></td>
                                                                <td><a href="order_detail.php?order_id=<?php echo $order_id; ?>" class="btn btn-dark btn-hover-primary btn-sm rounded-0">View</a></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="5">No orders found.</td></tr>';
                                                    }
                                                    ?>  
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="download" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Downloads</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Date</th>
                                                            <th>Expire</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $product_query = "SELECT p.name, o.created_at 
                                                            FROM order_items oi 
                                                            JOIN products p ON oi.product_id = p.id 
                                                            JOIN orders o ON oi.order_id = o.id 
                                                            WHERE o.user_id = '$user_id' 
                                                            ORDER BY o.created_at DESC";

                                                            $product_result = mysqli_query($conn, $product_query);

                                                            if (mysqli_num_rows($product_result) > 0) {
                                                            while ($product = mysqli_fetch_assoc($product_result)) {
                                                            $product_name = $product['name'];
                                                            $created_at = date('M d, Y', strtotime($product['created_at']));
                                                            // $download_link = $product['download_link']; // Direct download link
                                                            ?>
                                                            <tr>
                                                            <td><?php echo htmlspecialchars($product_name); ?></td>
                                                            <td><?php echo $created_at; ?></td>
                                                            <td>Never</td> <!-- Or dynamic expiry if you have -->
                                                            <td><a href="<?php echo $download_link; ?>" class="btn btn-dark btn-hover-primary rounded-0" target="_blank">
                                                            <i class="fa fa-cloud-download me-1"></i> Download File</a></td>
                                                            </tr>
                                                            <?php
                                                            }
                                                            } else {
                                                            echo '<tr><td colspan="4">No downloadable products found.</td></tr>';
                                                            }
                                                            ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Payment Method</h3>
                                            <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Billing Address</h3>
                                            <address>
                                                <p><strong>Alex Aya</strong></p>
                                                <p>1234 Market ##, Suite 900 <br>
                                        Lorem Ipsum, ## 12345</p>
                                                <p>Mobile: (123) 123-456789</p>
                                            </address>
                                            <a href="#" class="btn btn btn-dark btn-hover-primary rounded-0"><i class="fa fa-edit me-2"></i>Edit Address</a>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Account Details</h3>
                                            <div class="account-details-form">
                                                <form action="ajax/add_profile_data.php" method="POST">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="first-name" class="required mb-1">First Name</label>
                                                                <input type="text" id="first-name" name="first_name" placeholder="First Name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="last-name" class="required mb-1">Last Name</label>
                                                                <input type="text" id="last-name" name="last_name" placeholder="Last Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="display-name" class="required mb-1">Display Name</label>
                                                        <input type="text" id="display-name" name="display_name" placeholder="Display Name" />
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="email" class="required mb-1">Email Addres</label>
                                                        <input type="email" id="email" name="email" placeholder="Email Address" />
                                                    </div>
                                                    <fieldset>
                                                        <legend>Password change</legend>
                                                        <div class="single-input-item mb-3">
                                                            <label for="current-pwd" class="required mb-1">Current Password</label>
                                                            <input type="password" id="current-pwd" name="current_password" placeholder="Current Password" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item mb-3">
                                                                    <label for="new-pwd" class="required mb-1">New Password</label>
                                                                    <input type="password" id="new-pwd" name="password" placeholder="New Password" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item mb-3">
                                                                    <label for="confirm-pwd" class="required mb-1">Confirm Password</label>
                                                                    <input type="password" id="confirm-pwd" name="confirm_password" placeholder="Confirm Password" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="single-input-item single-item-button">
                                                        <button class="btn btn btn-dark btn-hover-primary rounded-0" type="submit">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->

                                </div>
                            </div>
                            <!-- My Account Tab Content End -->

                        </div>
                    </div>
                    <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("pages/footer.php"); ?>