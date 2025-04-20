<?php include('partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4">
            <h3>Orders</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Wooden Chair</td>
                    <td>$120</td>
                    <td><span class="badge bg-success">Completed</span></td>
                    <td>2024-09-28</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('partition/footer.php'); ?>