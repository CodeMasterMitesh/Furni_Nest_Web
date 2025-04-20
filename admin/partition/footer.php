
<!-- Footer -->
 <footer class="bgcolor border-top mt-5">
  <div class="container py-3 text-center">
    <p class="mb-0 text-dark" style="font-family: 'Poppins', sans-serif;">
      &copy; 2025 FurniNest Admin Panel. All rights reserved.
    </p>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php if (isset($successMessage)) : ?>
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span id="successMessage"><?php echo $successMessage; ?></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeModalBtn">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#successModal').modal('show');

    // Dynamically extract "category" from "add_category_form.php" and build "category.php"
    var currentPage = '<?php echo basename($_SERVER["PHP_SELF"]); ?>';
    var pageName = currentPage.replace(/(add_|edit_|delete_)/, '').replace('_form.php', '');
    console.log(pageName); // For debugging
    var redirectPage = pageName + '.php';
    console.log(redirectPage); // For debugging
    $('#closeModalBtn').click(function () {
      $('#successModal').modal('hide');
      setTimeout(function () {
        window.location.href = redirectPage;
      }, 300);
    });
  });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>