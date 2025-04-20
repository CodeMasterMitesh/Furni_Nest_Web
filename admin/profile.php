<?php 
session_start();
include('partition/header.php');

// Fetch user data
$sql = "SELECT * FROM users WHERE id = '" . $_SESSION['udata']['id'] . "'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['udata'] = mysqli_fetch_assoc($result);
} else {
    echo "No user found.";
    exit;
}

// === UPDATE PROFILE ===
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $id = $_SESSION['udata']['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);

    $img_path = $_SESSION['udata']['profile_image'];

    // File Upload
    if (!empty($_FILES['profile_image']['name'])) {
        $img_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $relativePath = "/uploads/" . $img_name;
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $relativePath;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
            $img_path = $relativePath;
        }
    }

    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone', profile_image='$img_path' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}

// === CHANGE PASSWORD ===
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $id = $_SESSION['udata']['id'];
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];

    $sql = "SELECT password FROM users WHERE id = '$id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if (password_verify($current, $row['password'])) {
        $new_hashed = password_hash($new, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password = '$new_hashed' WHERE id = '$id'";
        if (mysqli_query($conn, $update)) {
            $_SESSION['success'] = "Password updated successfully.";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['error'] = "Failed to update password.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }
}
?>

<div class="container mt-4">
  <h4 class="mb-4">User Profile</h4>

  <!-- Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- Update Form -->
  <form class="row g-3 mb-4" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="update_profile" value="1">
    <div class="col-md-6">
      <label class="form-label">First Name</label>
      <input type="text" class="form-control" name="first_name" value="<?php echo $_SESSION['udata']['first_name']; ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Last Name</label>
      <input type="text" class="form-control" name="last_name" value="<?php echo $_SESSION['udata']['last_name']; ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['udata']['email']; ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input type="text" class="form-control" name="phone" value="<?php echo $_SESSION['udata']['phone']; ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Profile Picture</label>
      <input type="file" name="profile_image" class="form-control">
      <?php if (!empty($_SESSION['udata']['profile_image'])): ?>
        <img src="<?php echo $_SESSION['udata']['profile_image']; ?>" width="60" class="mt-2 rounded-circle">
      <?php endif; ?>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Update Profile</button>
    </div>
  </form>

  <!-- Change Password -->
  <h5 class="mt-5">Change Password</h5>
  <form class="row g-3" method="POST">
    <input type="hidden" name="change_password" value="1">
    <div class="col-md-6">
      <label class="form-label">Current Password</label>
      <input type="password" class="form-control" name="current_password" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">New Password</label>
      <input type="password" class="form-control" name="new_password" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-warning">Change Password</button>
    </div>
  </form>
</div>

<?php include('partition/footer.php'); ?>