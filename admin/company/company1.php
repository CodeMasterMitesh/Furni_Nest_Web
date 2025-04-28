<?php include('../partition/header.php'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

<style>
    <style>
  body {
    font-size: 13px;
    background-color: #f8f9fa;
  }

  .table-sm th,
  .table-sm td {
    padding: 0.4rem;
  }

  .form-control-sm {
    height: calc(1.5em + .5rem + 2px);
    padding: .25rem .5rem;
  }

  .card {
    margin: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .breadcrumb {
    font-size: 12px;
  }
</style>

</style>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Masters</a></li>
          <li class="breadcrumb-item"><a href="#">HR</a></li>
          <li class="breadcrumb-item active" aria-current="page">Branch</li>
        </ol>
      </nav>
    </div>
    <div>
      <button class="btn btn-primary btn-sm">+ New Branch (F1)</button>
      <button class="btn btn-secondary btn-sm">Tools</button>
    </div>
  </div>

  <div class="card-body table-responsive">
    <table class="table table-bordered table-sm table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th><input type="checkbox" /></th>
          <th>Branch</th>
          <th>Branch Type</th>
          <th>Branch Code</th>
          <th>Area</th>
          <th>City</th>
          <th>Phone</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>DL No</th>
        </tr>
        <tr>
          <th></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
          <th><input type="text" class="form-control form-control-sm" /></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="checkbox" /></td>
          <td>Gandhidham</td>
          <td>Store</td>
          <td>01</td>
          <td>GANDHIDHAM</td>
          <td>GANDHIDHAM</td>
          <td>1234567890</td>
          <td>1234567890</td>
          <td>info@avbinternational.com</td>
          <td>DL001</td>
        </tr><tr>
          <td><input type="checkbox" /></td>
          <td>Surat</td>
          <td>Store</td>
          <td>01</td>
          <td>GANDHIDHAM</td>
          <td>GANDHIDHAM</td>
          <td>1234567890</td>
          <td>1234567890</td>
          <td>info@avbinternational.com</td>
          <td>DL001</td>
        </tr>
        <!-- Add more rows dynamically -->
      </tbody>
    </table>
  </div>

  <div class="card-footer d-flex justify-content-between align-items-center">
    <div>View 1 - 1 of 1</div>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-light btn-sm">&laquo;</button>
      <span>Page</span>
      <input type="number" value="1" class="form-control form-control-sm" style="width: 60px;">
      <span>of 1</span>
      <button class="btn btn-light btn-sm">&raquo;</button>
      <select class="form-select form-select-sm" style="width: 80px;">
        <option>100</option>
        <option>50</option>
        <option>25</option>
      </select>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('table').DataTable({
      paging: true,
      searching: true,
      info: false
    });
});
</script>
<script>
  document.getElementById('searchInput').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#companyTable tr');
    rows.forEach(row => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
</script>
<?php include('../partition/footer.php'); ?>