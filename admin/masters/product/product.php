<?php include('../../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4">
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
                                <a href="delete_product_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
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
<script>
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