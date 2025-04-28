<?php 
include('../partition/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $companyData = [];
  foreach ($_POST as $key => $value) {
    $companyData[$key] = mysqli_real_escape_string($conn, $value);
  }

  $columns = implode(", ", array_keys($companyData));
  $values = "'" . implode("', '", array_values($companyData)) . "'";

  $sql = "INSERT INTO company_master ($columns) VALUES ($values)";
  
  if (mysqli_query($conn, $sql)) {
      $successMessage = "Company added successfully!";
  } else {
      $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

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
    <div class="m-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <!-- Breadcrumb -->
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><i class="bi bi-house-door"></i> <a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="company.php">Company</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add Company</li>
        </ol>
      </nav>

      <!-- Action Buttons -->
      <div class="btn-group">
        <a href="company.php" class="btn btn-outline-secondary btn-sm">
          &lt;BACK(F3)
        </a>
        <button type="reset" form="companyForm" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-counterclockwise me-1"></i> RESET
        </button>
        <button type="submit" form="companyForm" class="btn btn-success btn-sm">
          <i class="bi bi-check-circle me-1"></i> SAVE(F2)
        </button>
      </div>
    </div>
      <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-building me-2"></i> Company Details
          </div>
        </div>
        <div class="card-body">
          <form method="POST" id="companyForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="row">
              <?php
                $fields = [
                  "company_name", "address_line", "city", "state", "country", "postal_code", "financial_year_start", "pan_number", "service_tax_number",
                  "phone_number", "email_address", "website_url", "gst_number", "company_code", "landmark", "parent_company_id", "area", "logo_path", "login_username",
                  "login_password", "bank_account_name", "bank_account_type", "bank_account_number", "bank_micr_code", "bank_rtgs_code", "bank_swift_code",
                  "bank_branch_address", "registered_address", "terms_conditions", "bank_name"
                ];

                foreach ($fields as $field) {
                  $label = ucwords(str_replace(["_", "no"], [" ", " No"], $field));
                  $inputType = 'text';

                  if ($field == 'email_address') $inputType = 'email';
                  elseif ($field == 'financial_year_start') $inputType = 'date';
                  elseif ($field == 'login_password') $inputType = 'password';
                  elseif ($field == 'terms_conditions') {
                    echo "
                      <div class='col-md-6 mb-1'>
                        <label class='form-label'>$label</label>
                        <textarea class='form-control' name='$field' rows='3'></textarea>
                      </div>";
                    continue;
                  }

                  echo "
                    <div class='col-md-3 mb-1'>
                      <label class='form-label'>$label</label>
                      <input type='$inputType' class='form-control' name='$field'>
                    </div>";
                }
              ?>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>
<?php include('../partition/footer.php'); ?>