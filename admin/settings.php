<?php include('partition/header.php'); ?>
<div class="container mt-4">
  <h4 class="mb-4">Settings</h4>

  <!-- Settings Form -->
  <form class="row g-3 mb-4">
    <div class="col-md-6">
      <label class="form-label">Site Title</label>
      <input type="text" class="form-control" placeholder="Enter site title">
    </div>
    <div class="col-md-6">
      <label class="form-label">Admin Email</label>
      <input type="email" class="form-control" placeholder="admin@example.com">
    </div>
    <div class="col-md-6">
      <label class="form-label">Timezone</label>
      <select class="form-select">
        <option selected>Asia/Kolkata</option>
        <option>UTC</option>
        <option>America/New_York</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Maintenance Mode</label><br>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox">
        <label class="form-check-label">Enable</label>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Save Settings</button>
    </div>
  </form>

  <!-- Settings Grid/Table -->
  <h5>Current Settings</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Setting</th>
          <th>Value</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Site Title</td>
          <td>My E-Commerce</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Timezone</td>
          <td>Asia/Kolkata</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php include('partition/footer.php'); ?>
