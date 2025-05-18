<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #0d6efd;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .form-container {
      background-color: white;
      color: #000;
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
    }

    .img-section {
      text-align: center;
    }

    .img-section h2 {
      margin-bottom: 30px;
      color: #fff;
    }

    .img-section img {
      max-width: 100%;
      height: auto;
    }

    @media (max-width: 768px) {
      .img-section h2 {
        font-size: 1.5rem;
        margin-top: 20px;
      }

      .form-container {
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row align-items-center justify-content-center g-4">
      <!-- Form -->
      <div class="col-lg-6">
        <div class="form-container">
          <form method="post" action="../controller/prosesSignup.php">
            <h2 class="mb-3 fw-bold">Let's Start!</h2>
            <p class="mb-4">Create your account and start exploring!</p>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama:</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas:</label>
              <input type="text" class="form-control" id="kelas" name="kelas" required>
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
              <label for="telepon" class="form-label">Telepon:</label>
              <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <p class="mb-3">Already have an account? <a href="loginUser.php" class="text-primary">Login</a></p>

            <div class="d-grid">
              <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Gambar -->
      <div class="col-lg-6 img-section">
        <h2 class="display-6 fw-bold">Come into our Business Center!</h2>
        <img src="../asset/student.png" alt="Student Illustration">
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
