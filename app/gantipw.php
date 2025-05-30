<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginUser.php");
    exit;
}
$id = $_SESSION['idAkun'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$dashboardLink = '#'; // default
if ($role == 'Admin') {
    $dashboardLink = 'dashboardAdmin.php';
} elseif ($role == 'Kasir') {
    $dashboardLink = 'dashboardKasir.php';
} elseif ($role == 'User') {
    $dashboardLink = 'dashboardUser.php';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ubah Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #0d6efd;
      color: white;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 10px;
      color: white;
    }

    .form-control {
      background-color: #ffffff;
      color: #000;
    }

    @media (max-width: 768px) {
      .login-image {
        display: none;
      }
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center">
      <!-- Gambar Samping -->
      <div class="col-lg-6 d-none d-lg-block text-center login-image">
        <img src="../asset/imagelogin.png" class="img-fluid" style="max-height: 500px;" alt="Change Password Image">
      </div>

      <!-- Form Ubah Password -->
      <div class="col-12 col-md-8 col-lg-4">
        <div class="form-container">
          <form method="post" action="../controller/updatepassword.php">
            <h3 class="mb-4 fw-bold">Ubah Password</h3>
            <p class="mb-4">Halo, <strong><?= htmlspecialchars($username) ?></strong>. Silakan masukkan password baru.</p>

            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <div class="mb-3">
              <label for="password" class="form-label">Password Baru</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru" required>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-light text-primary">Update Password</button>
            </div>

            <a href="<?= $dashboardLink ?>" class="text-light d-block text-center">← Kembali ke Halaman Sebelumnya</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
