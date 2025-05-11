<?php 
include('../../partition/header.php');

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$id = $_GET['id'] ?? null;
$cat = getsingleRow("categories","id=$id");
$pageTitle = "Edit Category";
?>

<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0"><i class="fas fa-tag me-2"></i><?php echo $pageTitle; ?></h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="category.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Back to Categories
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form id="editCategoryForm" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="table" value="categories">
                        <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php endif; ?>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="name" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
                                    <div class="form-text">Enter a unique category name</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select rounded-3 py-2" id="status" name="is_active">
                                      <option value="1" <?= $cat['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                      <option value="0" <?= $cat['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control rounded-3" id="description" name="description" rows="4"><?php echo htmlspecialchars($cat['description']); ?></textarea>
                                    <div class="form-text">Describe this category (optional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-save me-2"></i><?php echo $id ? 'Update' : 'Save'; ?> Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?php include('../../partition/footer.php'); ?>

<script>
$(document).ready(function() {
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();

        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...');

        var formData = new FormData(this);
        formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

        $.ajax({
            url: '../../ajax/updatedb.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'category.php'; // ✅ Redirect after SweetAlert
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                let msg = "An unexpected error occurred.";
                try {
                    const res = JSON.parse(xhr.responseText);
                    msg = res.message || msg;
                } catch (e) {}
                Swal.fire('Request Failed', msg, 'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save Category');
            }
        });
    });
});
</script>
