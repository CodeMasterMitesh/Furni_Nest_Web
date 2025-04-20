<?php 
include('../../partition/header.php');
if (isset($_GET['id'])) {
  $product_id = intval($_GET['id']);

  // Delete product images first
  $deleteImages = "DELETE FROM product_images WHERE product_id = $product_id";
  mysqli_query($conn,$deleteImages);

  // Then delete product
  $deleteProduct = "DELETE FROM products WHERE id = $product_id";
  $result = mysqli_query($conn,$deleteProduct);

  if ($result) {
      $successMessage = "Product Delete successfully!";
  } else {
      $successMessage = "Failed to delete product!";
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
  $successMessage = "Invalid request!";
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