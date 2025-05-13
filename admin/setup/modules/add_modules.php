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
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Modules</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="modules.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Back to Modules
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form id="addmodulesForm" class="ajax-submit" action="../../ajax/insertdb.php" data-redirect="/admin/setup/modules/modules.php" method="POST">
                      <input type="hidden" name="table" value="modules">
                      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="name" name="name" required>
                                    <div class="form-text">Enter a unique modules name</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sid" class="form-label fw-bold">Software</label>
                                    <select class="form-select rounded-3 py-2" id="sid" name="sid">
                                        <option value="NULL">None</option>
                                        <?php echo createDropdown("software","id","name");?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="parent_id" class="form-label fw-bold">Parent Modules</label>
                                    <select class="form-select rounded-3 py-2" id="parent_id" name="parent_id">
                                        <option value="NULL">None</option>
                                        <?php echo createDropdown("modules","id","name");?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code" class="form-label fw-bold">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="code" name="code" required>
                                    <div class="form-text">Enter a unique modules code</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="url" class="form-label fw-bold">URL <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="url" name="url" required>
                                    <div class="form-text">Enter a Complete url</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="icon" class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="icon" name="icon" required>
                                    <div class="form-text">Enter a unique modules Icon</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sort" class="form-label fw-bold">Sort <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="sort" name="sort" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="path" class="form-label fw-bold">Path <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 py-2" id="path" name="path" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select rounded-3 py-2" id="status" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-save me-2"></i>Save
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
</script>
