<?php include('../../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-2">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h4 class="fw-bold text-primary"><i class="fas fa-tags me-2"></i>Category Management</h4>
                <a href="add_category_form.php" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fas fa-plus me-2"></i>Add New Category
                </a>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-2 mb-1">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Categories List</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table id="categoriesTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th class="w-10">ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th class="text-center w-15">Status</th>
                                <th class="text-end w-15">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM categories";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td class="fw-bold">#<?php echo $row['id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape icon-md bg-light-primary rounded-3 me-3">
                                            <i class="fas fa-tag text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo $row['name']; ?></h6>
                                            <small class="text-muted">Created: <?php echo date('M d, Y', strtotime($row['created_at'])); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $row['description']; ?></td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo ($row['is_active'] ? 'success' : 'secondary'); ?>">
                                        <?php echo ($row['is_active'] ? 'Active' : 'Inactive'); ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="edit_category_form.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary rounded-start-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger delete-category rounded-end-2" data-id="<?php echo $row['id']; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary toggle-status ms-1 rounded-2" data-id="<?php echo $row['id']; ?>" data-status="<?php echo $row['is_active']; ?>">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Required JavaScript -->
<?php include('../../partition/footer.php'); ?>

<script>
$(document).ready(function() {
    // Initialize DataTable with enhanced features
    var table = $('#categoriesTable').DataTable({
        // dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
        //      "<'row'<'col-sm-12'tr>>" +
        //      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
       
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search categories...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        initComplete: function() {
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        }
    });

    // Global search
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Delete category functionality
    var deleteId;
    $(document).on('click', '.delete-category', function() {
        deleteId = $(this).data('id');
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    });
    
    $('#confirmDelete').click(function() {
        $.ajax({
            url: 'delete_category_form.php',
            type: 'POST',
            data: { id: deleteId },
            success: function(response) {
                if(response.success) {
                    table.row($('.delete-category[data-id="'+deleteId+'"]').closest('tr')).remove().draw();
                    $('#deleteModal').modal('hide');
                    // Show success toast
                    $('#toastMessage').html('<i class="fas fa-check-circle me-2"></i>' + response.message);
                    $('.toast').toast('show');
                } else {
                    $('#toastMessage').html('<i class="fas fa-exclamation-circle me-2"></i>' + response.message);
                    $('.toast').toast('show');
                }
            },
            error: function() {
                $('#toastMessage').html('<i class="fas fa-exclamation-circle me-2"></i>Error communicating with server');
                $('.toast').toast('show');
            }
        });
    });

    // Toggle status functionality
    $(document).on('click', '.toggle-status', function() {
        var btn = $(this);
        var categoryId = btn.data('id');
        var currentStatus = btn.data('status');
        var newStatus = currentStatus == 1 ? 0 : 1;
        
        $.ajax({
            url: 'toggle_category_status.php',
            type: 'POST',
            data: { 
                id: categoryId,
                status: newStatus
            },
            success: function(response) {
                if(response.success) {
                    btn.data('status', newStatus);
                    var badge = btn.closest('tr').find('.badge');
                    badge.removeClass('bg-success bg-secondary')
                         .addClass(newStatus ? 'bg-success' : 'bg-secondary')
                         .text(newStatus ? 'Active' : 'Inactive');
                    
                    $('#toastMessage').html('<i class="fas fa-check-circle me-2"></i>Status updated successfully');
                    $('.toast').toast('show');
                } else {
                    $('#toastMessage').html('<i class="fas fa-exclamation-circle me-2"></i>' + response.message);
                    $('.toast').toast('show');
                }   
            },
            error: function() {
                $('#toastMessage').html('<i class="fas fa-exclamation-circle me-2"></i>Error updating status');
                $('.toast').toast('show');
            }
        });
    });
});
</script>
