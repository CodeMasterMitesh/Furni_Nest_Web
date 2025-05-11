<!-- Footer -->
 <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this? This action cannot be undone.</p>
                <!-- <div class="alert alert-warning mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Deleting this data may affect associated products.
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill" id="confirmDelete">
                    <i class="fas fa-trash-alt me-1"></i> Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Notification Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto"><i class="fas fa-check-circle me-2"></i>Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
        </div>
    </div>
</div>
 <footer class="bgcolor border-top">
  <div class="container py-3 text-center">
    <p class="mb-0 text-dark" style="font-family: 'Poppins', sans-serif;">
      &copy; 2025 FurniNest Admin Panel. All rights reserved.
    </p>
  </div>
</footer>
<script>
  document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function (element) {
    element.addEventListener('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
      const submenu = this.nextElementSibling;
      if (submenu) {
        submenu.classList.toggle('show');
      }
    });
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
  $(document).ready(function () {
    $('form.ajax-submit').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const redirectUrl = form.data('redirect'); // dynamic redirect
        const formData = new FormData(this);
        
        formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (xhr) {
                let msg = "An unexpected error occurred.";
                try {
                    const res = JSON.parse(xhr.responseText);
                    msg = res.message || msg;
                } catch (e) {}
                Swal.fire('Request Failed', msg, 'error');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save');
            }
        });
    });


    // Delete software functionality
    var deleteId;
    var deleteTable;
    $(document).on('click', '.delete-tbdata', function() {
        deleteId = $(this).data('id');
        deleteTable = $(this).data('table');
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    });

    $('#confirmDelete').click(function() {
        const csrfToken = "<?= $_SESSION['csrf_token'] ?>";
        $.ajax({
            url: '../../ajax/deletedb.php',
            type: 'POST',
            data: {
                id: deleteId,
                table: deleteTable,
                csrf_token: csrfToken
            },
            success: function(response) {
              console.log(response);
                if (response.success) {
                    $('.delete-tbdata[data-id="' + deleteId + '"]').closest('tr').fadeOut(300, function () {
                        $(this).remove();
                    });
                    $('#deleteModal').modal('hide');
                    $('#toastMessage').html('<i class="fas fa-check-circle me-2"></i>' + response.message);
                    $('.toast').toast('show');
                    // Optional: Reload if you want updated state
                    setTimeout(() => location.reload(), 1000);
                } else {
                    $('#deleteModal').modal('hide');
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
});
</script>
</body>
</html>