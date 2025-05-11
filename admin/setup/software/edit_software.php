<?php 
include('../../partition/header.php');

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$id = $_GET['id'] ?? null;
$software = getsingleRow("software","id=$id");
$pageTitle = "Edit Software";
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
                            <a href="software.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Back to Software
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form id="editSoftwareForm" class="ajax-submit" action="../../ajax/updatedb.php" data-redirect="/admin/setup/software/software.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="table" value="software">
                        <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php endif; ?>
                        
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="name" name="name" value="<?php echo htmlspecialchars($software['name']); ?>" required>
                                    <div class="form-text">Enter a unique software name</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code" class="form-label fw-bold">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="code" value="<?php echo htmlspecialchars($software['code']); ?>" name="code" required>
                                    <div class="form-text">Enter a unique software code</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="slug" class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="slug" value="<?php echo htmlspecialchars($software['slug']); ?>" name="slug" required>
                                    <div class="form-text">Enter a unique software Slug</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="icon" class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="icon" value="<?php echo htmlspecialchars($software['icon']); ?>" name="icon" required>
                                    <div class="form-text">Enter a unique software Icon</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                          <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sort" class="form-label fw-bold">Sort <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="sort" value="<?php echo htmlspecialchars($software['sort']); ?>" name="sort" required>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select rounded-3 py-2" id="status" name="is_active">
                                      <option value="1" <?= $software['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                      <option value="0" <?= $software['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-save me-2"></i><?php echo $id ? 'Update' : 'Save'; ?> Software
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