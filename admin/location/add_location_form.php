<?php 
include('../partition/header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  // exit;
  // Getting categories details from the form
  $name = $_POST['name'];
  $description = $_POST['description'];

  // Insert product details into the categories table
  $sql = "INSERT INTO categories (name, description) VALUES ('$name','$description')";
  if (mysqli_query($conn, $sql)) {
    // echo $sql;
      $successMessage = "Category added successfully!";
  } else {
    $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  echo "
    <script>
        var successMessage = '$successMessage'; 
        $(document).ready(function() {
            $('#successMessage').text(successMessage);
            $('#successModal').modal('show');
        });
    </script>
    ";
}
?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
      <div class="container mt-5">
        <div class="row justify-content-between">
          <div class="col-3">
            <h3>Add Category</h3>
          </div>
          <div class="col-3">
            <a class="btn btn-primary btn-md float-end" href="category.php">Back</a>
          </div>
        </div>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Category Name</label>
            <input type="text" class="form-control" name="name">
          </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
          </div>
          <button class="btn btn-primary">Save Category</button>
        </form>
      </div>
    </div>
  </div>
  <?php include('../partition/footer.php'); ?>