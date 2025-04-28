<?php include('../../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Categories</h3>
                <a href="add_category_form.php" class="btn btn-primary">Add Category</a>
            </div>
            <input type="text" class="form-control mb-3" placeholder="Search Category..." id="searchInput">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="categoryTable">
                    <?php 
                        $sql = "SELECT * FROM categories";
                        $result = mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td>
                                    <a href="edit_category_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button href="delete_category_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
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
    let rows = document.querySelectorAll('#categoryTable tr');
    rows.forEach(row => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
</script>
<?php include('../../partition/footer.php'); ?>