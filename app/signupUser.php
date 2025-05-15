<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SignUp</title>
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
        border-radius: 50px;
        color: #000;
        padding: 50px;
        background-color: white;
        width: 500px;
        height: 600px;
        color: white;
        margin-top: 220px;
        margin-left: 150px;
    }
  </style>
</head>
<body>
    <div class="d-flex">
        <div class="form-container text-dark">
            <form method="post" action="../controller/prosesLogin.php">
                <h2 class="mb-4 text-left display-5 fw-bold">Let's to Start!</h2>
                <p class="mb-5">Create your account and start explore!</p>
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <p class="mb-5">have an account? <a href="loginUser.php" class="text-primary">Login.</a></P>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
        <div class="img">
            <h2 class="text-center display-5" style="margin-top: 200px; margin-left: 120px;">Come in to our Bisnis Center!</h2>
            <img src="../asset/student.png" style="width: 800px; margin-top: 40px; margin-left: 150px;">
        </div>
    </div>
</body>
</html>
