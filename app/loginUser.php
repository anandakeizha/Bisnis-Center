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
      height: 100vh;
      display: flex;
    }

    .form-container {
      color: #000;
      padding: 30px;
      width: 100%;
      max-width: 600px;
      color: white;
      margin-top: 250px;
      margin-left: 140px;
    }
  </style>
</head>
<body>
    <div class="d-flex">
        <div class="img">
            <img src="../asset/imagelogin.png" style="width: 700px; margin-top: 180px; margin-left: 120px;">
        </div>
        <div class="form-container">
        <form method="post" action="../controller/prosesLogin.php">
            <h5 class="mb-4 text-left display-5 fw-bold">Welcome to Bisnis Center</h5>
            <p class="mb-5">get started for your experience on our business center</p>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <p>Don't have an account? <a href="signupUser.php" class="text-light">Sign Up.</a></P>
            <div class="d-grid">
                <button type="submit" class="btn btn-light text-primary">Login</button>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
