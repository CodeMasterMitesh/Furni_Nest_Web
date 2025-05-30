<?php 
include('../../partition/header.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Category</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="category.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Back to Categories
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form id="addCategoryForm" class="ajax-submit" action="../../ajax/insertdb.php" data-redirect="/admin/masters/inventory/category.php" method="POST">
                      <input type="hidden" name="table" value="categories">
                      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="name" name="name" required>
                                    <div class="form-text">Enter a unique category name</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select rounded-3 py-2" id="status" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control rounded-3" id="description" name="description" rows="4"></textarea>
                                    <div class="form-text">Describe this category (optional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-save me-2"></i>Save Category
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
