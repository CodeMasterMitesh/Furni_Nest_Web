<?php include('../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Company</h3>
                <a href="add_company_form.php" class="btn btn-primary">Add Compnay</a>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="text"  class="form-control mb-3" placeholder="Search Category..." id="searchInput">
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="companyTable">
                    <?php 
                        $sql = "SELECT * FROM company_master";
                        $result = mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['company_name']; ?></td>
                                <td><?php echo $row['address_line']; ?></td>
                                <td>
                                    <a href="edit_company_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button href="delete_company_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
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
    let rows = document.querySelectorAll('#companyTable tr');
    rows.forEach(row => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
</script>
<?php include('../partition/footer.php'); ?>