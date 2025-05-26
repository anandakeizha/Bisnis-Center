<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<style>
  .nav-link {
    position: relative;
    text-decoration: none;
  }
  .nav-link::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 2px;
    left: 0;
    bottom: 0;
    background-color: white;
    transition: width 0.3s ease;
  }
  .nav-link:hover::after {
    width: 100%;
  }
</style>
</head>
<body class="bg-primary text-white">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand text-white fw-bold" href="#">Bisnis Center</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item mx-2"><a class="nav-link text-white" href="#home">Home</a></li>
          <li class="nav-item mx-2"><a class="nav-link text-white" href="#about">About us</a></li>
          <li class="nav-item mx-2"><a class="nav-link text-white" href="#service">Service</a></li>
          <li class="nav-item mx-2"><a class="nav-link text-white" href="#contact">Contact us</a></li>
        </ul>
        <div class="d-flex">
          <a href="signupUser.php" class="btn btn-light me-2 text-primary">Sign Up</a>
          <a href="loginUser.php" class="btn btn-outline-light">Login</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <section class="py-5" id="home">
    <div class="container">
      <div class="row align-items-center text-center text-md-start">
        <div class="col-md-6">
          <h4>Welcome!</h4>
          <h1 class="fw-bold display-4">Bisnis Center</h1>
          <span class="typed-text fw-bold fs-5"></span>
        </div>
        <div class="col-md-6">
          <img src="../asset/header_photo.png" alt="Header" class="img-fluid mt-4 mt-md-0">
        </div>
      </div>
    </div>
  </section>

  <!-- Typed.js -->
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script>
    var typed = new Typed(".typed-text", {
      strings: ['Twenty Four Vocational High School'],
      loop: true,
      backSpeed: 40,
      typeSpeed: 80
    });
  </script>

  <!-- About -->
  <section class="bg-white text-dark py-5" id="about">
    <div class="container">
      <h2 class="text-center text-primary fw-bold">About Us</h2>
      <p class="text-center mt-3">Kami adalah platform yang mendukung fasilitas sekolah agar berkembang secara digital dan profesional.</p>
      <div class="row align-items-center mt-5">
        <div class="col-md-6 mb-4 mb-md-0">
          <img src="../asset/high-school-concept-illustration.png" class="img-fluid">
        </div>
        <div class="col-md-6">
          <h4 class="text-primary fw-bold">Bisnis Center SMKN 24</h4>
          <p class="mt-3">adalah fasilitas minimarket sekolah yang melengkapi kebutuhan siswa di sekolah. 
        Minimarket ini menyediakan berbagai kebutuhan harian seperti alat tulis, makanan ringan, minuman, hingga perlengkapan praktek. 
        Dengan harga yang terjangkau dan lokasi yang strategis di lingkungan sekolah, siswa dapat memenuhi kebutuhan mereka tanpa harus keluar dari area sekolah. 
        Selain itu, pengelolaan minimarket ini juga menjadi bagian dari praktik kewirausahaan siswa untuk mengembangkan keterampilan bisnis secara langsung.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Service -->
  <section class="bg-primary text-white py-5" id="service">
    <div class="container">
      <h2 class="text-center fw-bold">Our Service</h2>
      <div class="row mt-5">
        <div class="col-md-4 mb-4">
          <div class="card shadow service-card text-center">
            <div class="card-body">
              <img src="../asset/Statistics analysis on laptop.png" class="img-fluid" style="height: 150px;">
            </div>
          </div>
          <h5 class="text-center mt-3 fw-bold">Mengembangkan Layanan Bisnis Sekolah</h5>
          <p class="text-center">Bisnis Center SMKN 24 juga akan membimbing siswa bagaimana caranya melayani dan memberikan service terhadap customer.</p>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow service-card text-center">
            <div class="card-body">
              <img src="../asset/isometric view of notebook with stickers notes and pencils.png" class="img-fluid" style="height: 150px;">
            </div>
          </div>
          <h5 class="text-center mt-3 fw-bold">Menyediakan kebutuhan siswa</h5>
          <p class="text-center">Fasilitas kami menyediakan berbagai kebutuhan siswa yang mendasar sebagai pelajar.</p>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow service-card text-center">
            <div class="card-body">
              <img src="../asset/payment terminal.png" class="img-fluid" style="height: 150px;">
            </div>
          </div>
          <h5 class="text-center mt-3 fw-bold">Menyesuaikan Sistem Pembayaran</h5>
          <p class="text-center">Kami menyediakan fleksibilitas dalam sistem pembayaran terhadap siswa atau guru serta mengikuti trend teknologi kedepannya.</p>
        </div>
      </div>

      <div class="row mt-5 align-items-center">
        <div class="col-md-6">
          <img src="../asset/flat-customer-support-illustration.png" class="img-fluid">
        </div>
        <div class="col-md-6">
          <h1 class="fw-bold display-6">Service is more important in Bisnis Center</h1>
          <p class="mt-3">Menjadikan sebuah layanan yang baik untuk menciptakan lingkungan yang sehat disekolah.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section class="bg-white text-dark py-5" id="contact">
    <div class="container">
      <h2 class="text-center fw-bold text-primary">Contact us</h2>
      <div class="row text-center mt-5">
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold text-primary">Bisnis Center SMKN 24 Jakarta</h5>
          <p>Fasilitas Bisnis Center Sekolah</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold">Service</h5>
          <p>School supplies</p>
          <p>School staff management</p>
          <p>Student Service</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold">About</h5>
          <p>Bisnis Center</p>
          <p>Business</p>
          <p>Team</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold">Contact</h5>
          <p>Staff</p>
          <p>Management</p>
        </div>
      </div>

      <div class="text-center mt-4">
        <i class="bi bi-instagram me-3"> @bctweentyfour</i>
        <i class="bi bi-envelope"> @bisniscenter24</i>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center mt-3 pb-3">
    <div class="d-flex justify-content-center align-items-center">
      <i class="bi bi-c-circle me-2">Copyright 2025</i>
      <img src="../asset/logo_dupat-removebg-preview.png" style="width: 30px; height: 30px;">
    </div>
  </footer>
</body>
</html>
