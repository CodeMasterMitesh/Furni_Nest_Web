<?php include('../../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Products</h3>
                <a href="add_product_form.php" class="btn btn-primary">Add Product</a>
            </div>
            <input type="text" class="form-control mb-3" placeholder="Search Products..." id="searchInput">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>SKU</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="productTable">
                <?php 
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);
                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['category_id']; ?></td>
                            <td><?php echo $row['SKU']; ?></td>
                            <td>
                                <a href="edit_product_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault(); // Stop default link behavior

    var id = $(this).data('id');      // Get product ID
    var row = $(this).closest('tr');  // Optional: reference the row for removal

    if (confirm("Are you sure you want to delete this product?")) {
        $.ajax({
            url: 'delete_product_form.php', // PHP handler
            type: 'POST',                   // Use POST for data modification
            data: { id: id },               // Send only the ID
            dataType: 'json',             // Expect plain text response (can be 'json' if you update PHP)
            success: function(response) {
                console.log(response);
                if (response.status === "success") {
                    $('#successModal').modal('show');  // Show success modal
                    row.fadeOut(300);                  // Optionally fade out row
                } else {
                    $('#errorModal').modal('show');    // Show error modal on unexpected response
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + error);  // For debugging
                $('#errorModal').modal('show');         // Show error modal on failure
            }
        });
    }
});

  document.getElementById('searchInput').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#productTable tr');
    rows.forEach(row => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
</script>
<?php include('../../partition/footer.php'); ?>