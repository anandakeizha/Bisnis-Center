<?php 
session_start();
if($_SESSION['role'] == "admin" && $_SESSION['role'] == "kasir")
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
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
      <!-- Gambar Login -->
      <div class="col-lg-6 d-none d-lg-block text-center login-image">
        <img src="../asset/imagelogin.png" class="img-fluid" style="max-height: 500px;" alt="Login Image">
      </div>

      <!-- Form Login -->
      <div class="col-12 col-md-8 col-lg-4">
        <div class="form-container">
          <form method="post" action="../controller/prosesLogin.php">
            <h3 class="mb-4 fw-bold">Welcome to Bisnis Center</h3>
            <p class="mb-4">Get started with your business experience</p>
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <p>Don't have an account? <a href="signupUser.php" class="text-light">Sign Up.</a>
            </p>Forget password ? <a href="lupapassword.php" class="text-light">reset password.</a></p>
            <div class="d-grid">
              <button type="submit" class="btn btn-light text-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
