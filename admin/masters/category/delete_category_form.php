<?php 
include('../../partition/header.php');
if (isset($_GET['id'])) {
  $category_id = intval($_GET['id']);

  // Then delete category
  $caregory = "DELETE FROM categories WHERE id = $category_id";
  $result = mysqli_query($conn,$caregory);

  if ($result) {
      $successMessage = "Category Delete successfully!";
  } else {
      $successMessage = "Failed to delete Category!";
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
} else {
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
<?php include('../../partition/footer.php'); ?>