<?php 
include('../../../partition/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $title = $_POST['title'];
  $price = $_POST['price'];
  $sku = $_POST['sku'];
  $small_description = $_POST['small_description'];
  $tag = $_POST['tag'];
  $size = $_POST['size'];
  $color = $_POST['color'];
  $category = $_POST['category_id'];
  $details = mysqli_escape_string($conn,$_POST['description']);

  // Insert product data
  $sql = "INSERT INTO products (name, title, price, sku, small_description, tag, size, color, category_id, description)
          VALUES ('$name', '$title', '$price', '$sku', '$small_description', '$tag', '$size', '$color', '$category', '$details')";

  if (mysqli_query($conn, $sql)) {
      $product_id = mysqli_insert_id($conn);

      // Handle image upload
      if (isset($_FILES['image_path'])) {
          foreach ($_FILES['image_path']['name'] as $key => $name) {
              $tmp_name = $_FILES['image_path']['tmp_name'][$key];
              $newName = time() . '-' . basename($name);
              $relativePath = 'uploads/products/' . $newName;
              $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $relativePath;

              if (move_uploaded_file($tmp_name, $uploadPath)) {
                  // Save full relative path in DB
                  $insertImageQuery = "INSERT INTO product_images (product_id, image_path)
                                       VALUES ('$product_id', '$relativePath')";
                  mysqli_query($conn, $insertImageQuery);
              }
          }
      }

      $successMessage = "Product added successfully!";
  } else {
      $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  // Show modal via JS
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
<style>
  
</style>
<div class="wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1">
    <div class="container mt-5">
      <div class="card card-react-style p-4">
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-md-6">
            <h3 class="mb-0 fw-semibold">🛒 Add Product</h3>
          </div>
          <div class="col-md-6 text-end">
            <a class="btn btn-primary" href="product.php"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>

        <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
          <div class="row g-4">

            <!-- Floating Input Fields -->
            <?php
              $fields = [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'title', 'label' => 'Title'],
                ['name' => 'price', 'label' => 'Price'],
                ['name' => 'sku', 'label' => 'SKU'],
                ['name' => 'small_description', 'label' => 'Small Description'],
                ['name' => 'tag', 'label' => 'Tag'],
                ['name' => 'size', 'label' => 'Size'],
                ['name' => 'color', 'label' => 'Color'],
              ];

              foreach ($fields as $field) {
                echo '<div class="col-md-6">
                        <div class="form-floating">
                          <input type="text" class="form-control" name="'.$field['name'].'" placeholder="'.$field['label'].'" required>
                          <label>'.$field['label'].'</label>
                        </div>
                      </div>';
              }
            ?>

            <div class="col-md-6">
              <label class="form-label">Category</label>
              <?= createDropdown('category_id', 'categories', 'id', 'name'); ?>
            </div>

            <!-- Multiple Image Upload -->
            <div class="col-12 mt-3">
              <label class="form-label">Upload Images</label>
              <div id="image-upload-wrapper">
                <div class="row image-upload-group g-2 mb-2">
                  <div class="col-md-10">
                    <input type="file" class="form-control image-input" name="image_path[]" onchange="previewImage(this)" required>
                    <div class="preview mt-2"></div>
                  </div>
                  <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-image">Remove</button>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-1" id="addImageField">+ Add More</button>
            </div>

            <!-- Description -->
            <div class="col-12">
              <label class="form-label">Details</label>
              <textarea class="form-control" name="description" rows="4" placeholder="Enter product details..." required></textarea>
            </div>

            <!-- Submit -->
            <div class="col-12 text-end">
              <button class="btn btn-success mt-3"><i class="bi bi-check-circle"></i> Save Product</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </main>

  <?php include('../../../partition/footer.php'); ?>
</div>

<script>
  // Add more image fields
  document.getElementById('addImageField').addEventListener('click', function () {
    const wrapper = document.getElementById('image-upload-wrapper');
    const clone = wrapper.querySelector('.image-upload-group').cloneNode(true);
    clone.querySelector('.image-input').value = '';
    clone.querySelector('.preview').innerHTML = '';
    wrapper.appendChild(clone);
  });

  // Remove image input
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-image')) {
      const group = e.target.closest('.image-upload-group');
      if (document.querySelectorAll('.image-upload-group').length > 1) {
        group.remove();
      }
    }
  });

  // Preview image
  function previewImage(input) {
    const preview = input.parentElement.querySelector('.preview');
    preview.innerHTML = '';
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        preview.appendChild(img);
      }
      reader.readAsDataURL(file);
    }
  }
</script>