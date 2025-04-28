<?php 
include('partition/header.php');
$product_id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $title = $_POST['title'];
  $price = $_POST['price'];
  $sku = $_POST['SKU'];
  $small_description = $_POST['small_description'];
  $tag = $_POST['tag'];
  $size = $_POST['size'];
  $color = $_POST['color'];
  $category = $_POST['category_id'];
  $details = $_POST['description'];

  // Update product
  $updateQuery = "UPDATE products SET 
      name='$name', title='$title', price='$price', SKU='$sku',
      small_description='$small_description', tag='$tag', size='$size', 
      color='$color', category_id='$category', description='$details'
      WHERE id='$product_id'";
  mysqli_query($conn, $updateQuery);

  // Delete selected images
  if (!empty($_POST['delete_images'])) {
    foreach ($_POST['delete_images'] as $img_id) {
      $getImage = mysqli_query($conn, "SELECT image_path FROM product_images WHERE id='$img_id'");
      $row = mysqli_fetch_assoc($getImage);
      $filePath = "../uploads/products/" . $row['image_path'];
      if (file_exists($filePath)) unlink($filePath);
      mysqli_query($conn, "DELETE FROM product_images WHERE id='$img_id'");
    }
  }

  // Upload new images
  if (isset($_FILES['image_path'])) {
    foreach ($_FILES['image_path']['name'] as $key => $name) {
      $tmp_name = $_FILES['image_path']['tmp_name'][$key];
      $newName = time() . '-' . basename($name);
      $uploadPath = "../uploads/products/" . $newName;
      if (move_uploaded_file($tmp_name, $uploadPath)) {
        $insertImageQuery = "INSERT INTO product_images (product_id, image_path)
                             VALUES ('$product_id', '$newName')";
        mysqli_query($conn, $insertImageQuery);
      }
    }
  }

  $successMessage = "Product updated successfully!";
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
            <h3>Edit Product</h3>
          </div>
          <div class="col-3">
            <a class="btn btn-primary btn-md float-end" href="product.php">Back</a>
          </div>
        </div>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?= $product['name'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="<?= $product['title'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Price</label>
            <input type="text" class="form-control" name="price" value="<?= $product['price'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>SKU</label>
            <input type="text" class="form-control" name="SKU" value="<?= $product['SKU'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Small Description</label>
            <input type="text" class="form-control" name="small_description" value="<?= $product['small_description'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Tag</label>
            <input type="text" class="form-control" name="tag" value="<?= $product['tag'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Size</label>
            <input type="text" class="form-control" name="size" value="<?= $product['size'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Color</label>
            <input type="text" class="form-control" name="color" value="<?= $product['color'] ?>" required>
          </div>
          <div class="col-md-6">
            <label>Category</label>
            <?php echo createDropdown('category_id', 'categories', 'id', 'name', $product['category_id']); ?>
          </div>

          <!-- Existing images -->
          <div class="col-md-12 mt-3">
            <label>Existing Images</label>
            <div class="row">
              <?php
              $images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$product_id'");
              while ($img = mysqli_fetch_assoc($images)) {
                echo '
                  <div class="col-md-3 text-center mb-3">
                    <img src="../uploads/products/' . $img['image_path'] . '" class="img-thumbnail" style="height: 100px;"><br>
                    <label class="mt-2">
                      <input type="checkbox" name="delete_images[]" value="' . $img['id'] . '"> Remove
                    </label>
                  </div>';
              }
              ?>
            </div>
          </div>

          <!-- New image uploads -->
          <div class="col-md-12 mt-3">
            <label>Upload New Images</label>
            <div id="image-upload-wrapper">
              <div class="row mb-2 image-upload-group">
                <div class="col-md-10">
                  <input type="file" class="form-control image-input" name="image_path[]" onchange="previewImage(this)">
                  <div class="preview mt-2"></div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                  <button type="button" class="btn btn-danger btn-sm remove-image">Remove</button>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm" id="addImageField">+ Add More</button>
          </div>

          <div class="col-md-12">
            <label>Details</label>
            <textarea class="form-control" name="description" rows="4" required><?= $product['description'] ?></textarea>
          </div>
        </div>
        <button class="btn btn-success mt-3">Update Product</button>
      </form>
    </div>
  </main>
  <?php include('partition/footer.php'); ?>
</div>

<script>
  document.getElementById("addImageField").addEventListener("click", function () {
    const wrapper = document.getElementById("image-upload-wrapper");
    const group = document.createElement("div");
    group.classList.add("row", "mb-2", "image-upload-group");
    group.innerHTML = `
      <div class="col-md-10">
        <input type="file" class="form-control image-input" name="image_path[]" onchange="previewImage(this)">
        <div class="preview mt-2"></div>
      </div>
      <div class="col-md-2 d-flex align-items-center">
        <button type="button" class="btn btn-danger btn-sm remove-image">Remove</button>
      </div>
    `;
    wrapper.appendChild(group);
  });

  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-image")) {
      e.target.closest(".image-upload-group").remove();
    }
  });

  function previewImage(input) {
    const previewDiv = input.parentNode.querySelector(".preview");
    previewDiv.innerHTML = '';
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.style.height = "100px";
        img.classList.add("me-2", "border", "p-1");
        previewDiv.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  }
</script>