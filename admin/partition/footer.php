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

</body>
</html>