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

      .header{
        margin-left: 250px;
        margin-top: 310px;
      }

      .typed-text{
        font-size: 25px;
      }

      html{
        scroll-behavior: smooth;
      }

      .service-card {
        height: 300px;

      }

      .service-img {
        width: 90%;
        height: 90%;
        object-fit: contain;
        margin-top: -20px;
      }

      .payment-img {
        width: 70%;
        height: 70%;
        object-fit: contain;
        margin-top: -20px;
      }

      .tool-img{
        width: 80%;
        height: 80%;
        object-fit: contain;
      }

    </style>
</head>
<body class="mb-2 bg-primary text-white">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center position-relative">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center ms-5" id="navbarSupportedContent">
        <ul class="navbar-nav position-absolute start-50 translate-middle-x d-flex flex-row mb-2 mb-lg-0">
          <li class="nav-item mx-3">
            <a class="nav-link active text-white" aria-current="page" href="#home">Home</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link active text-white" aria-current="page" href="#about">About us</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link active text-white" aria-current="page" href="#service">Service</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link active text-white" aria-current="page" href="#contact">Contact us</a>
          </li>
        </ul>
      </div>
      <form class="d-flex" role="search">
        <a href="" class="btn btn-light me-2 text-primary" type="submit">Sign Up</a>
        <a href="loginUser.php" class="btn btn-outline-light" type="submit">Login</a>
    </form>
    </div>
  </nav>
  <section class="header text-left fw-bold" id="home">
    <div class="d-flex">
      <div class="header-text me-5">
        <h4 class="">Welcome!</h4>
        <h1 class="fw-bold display-1">Bisnis Center</h1>
        <span class="typed-text fw-bold"></span>
        <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
        <script>
        var typed = new Typed(".typed-text", {
          strings: ['Twenty Four Vocational High School'],
          loop:true,
          backSpeed:40,
          typeSpeed:80
        });
      </script>
     </div>
     <div class="image-header">
      <img src="../asset/header_photo.png" class="image align-items-center" style="max-width: 100%; width: 850px; margin-top: -100px;">
     </div>
    </div>
  </section>
  <section class="bg-white text-dark py-5" id="about">
  <div class="container">
    <h2 class="fw-bold text-center text-primary">About Us</h2>
    <h5 class="text-center mt-4">Kami adalah platform yang mendukung fasilitas sekolah agar berkembang secara digital dan profesional.</h5>
    <div class="d-flex">
      <img src="../asset/high-school-concept-illustration.png" class="image align-items-left" style="max-width: 100%; width: 700px; margin-left: -100px; margin-top: -60px;">
      <div>
        <h4 class="fw-bold display-6 text-primary" style="margin-top: 150px; margin-left: 60px">Bisnis Center SMKN 24</h4>
        <p class="text-left mt-4" style="margin-left: 60px;">adalah fasilitas minimarket sekolah yang melengkapi kebutuhan siswa di sekolah. 
        Minimarket ini menyediakan berbagai kebutuhan harian seperti alat tulis, makanan ringan, minuman, hingga perlengkapan praktek. 
        Dengan harga yang terjangkau dan lokasi yang strategis di lingkungan sekolah, siswa dapat memenuhi kebutuhan mereka tanpa harus keluar dari area sekolah. 
        Selain itu, pengelolaan minimarket ini juga menjadi bagian dari praktik kewirausahaan siswa untuk mengembangkan keterampilan bisnis secara langsung.</p>
        <button class="btn btn-outline-primary mt-3" style="margin-left: 60px;">Read more</button>
      </div>
    </div>
  </div>
</section>
<section class="bg-primary text-white" id="service">
  <div class="container">
    <h2 class="fw-bold text-center mt-5">Our Service</h2>
    <div class="row mt-5">
      <div class="col-md-4">
        <div class="card shadow service-card">
          <div class="card-body d-flex align-items-center justify-content-center">
            <img src="../asset/Statistics analysis on laptop.png" class="service-img">
          </div>
        </div>
        <h5 class="fw-bold text-center mt-4">Mengembangkan Layanan Bisnis Sekolah</h5>
        <p class="text-center">Bisnis Center SMKN 24 juga akan membimbing siswa bagaimana caranya melayani dan memberikan service terhadap customer.</p>
      </div>
      <div class="col-md-4">
        <div class="card shadow service-card">
          <div class="card-body d-flex align-items-center justify-content-center">
            <img src="../asset/isometric view of notebook with stickers notes and pencils.png" class="tool-img">
          </div>
        </div>
        <h5 class="fw-bold text-center mt-4">Menyediakan kebutuhan siswa</h5>
        <p class="text-center">Fasilitas kami menyediakan berbagai kebutuhan siswa yang mendasar sebagai pelajar.</p>
      </div>
      <div class="col-md-4">
        <div class="card shadow service-card">
          <div class="card-body d-flex align-items-center justify-content-center">
            <img src="../asset/payment terminal.png" class="payment-img">
          </div>
        </div>
        <h5 class="fw-bold text-center mt-4">Menyesuaikan Sistem Pembayaran </h5>
        <p class="text-center">Kami menyediakan fleksibilitas dalam sistem pembayaran terhadap siswa atau guru serta mengikuti trend teknologi kedepannya.</p>
      </div>
  </div>
  <div class="d-flex">
    <img src="../asset/flat-customer-support-illustration.png" class="image align-items-center" style="max-width: 100%; width: 500px; margin-top: 50px;">
    <div>
      <h1 class="fw-bold display-4" style="margin-top: 200px; margin-left: 70px">Service is more important in Bisnis Center</h1>
      <p class="text-center mt-4" style="margin-left: 8px;">Menjadikan sebuah layanan yang baik untuk menciptakan lingkungan yang sehat disekolah.</p>
    </div>
  </div>
</section>
<section class="bg-white text-dark py-1" id="contact">
  <div class="container mt-5">
    <h2 class="fw-bold text-center text-primary">Contact us</h2>
    <div class="d-flex justify-content-center">
      <div class="mt-5">
        <h5 class="fw-bold text-primary">Bisnis Center SMKN 24 Jakarta</h5>
        <p>Fasilitas Bisnis Center Sekolah</p>
      </div>
      <div class="mt-5">
        <h5 class="fw-bold mb-4" style="margin-left: 80px;">Service</h5>
        <p style="margin-left: 80px;">School supplies</p>
        <p style="margin-left: 80px;">School staff management</p>
        <p style="margin-left: 80px;">Student Service</p>
      </div>
      <div class="mt-5">
        <h5 class="fw-bold mb-4" style="margin-left: 100px;">About</h5>
        <p style="margin-left: 100px;">Bisnis Center</p>
        <p style="margin-left: 100px;">Business</p>
        <p style="margin-left: 100px;">Team</p>
      </div>
      <div class="mt-5">
        <h5 class="fw-bold mb-4" style="margin-left: 100px;">Contact</h5>
        <p style="margin-left: 100px;">Staff</p>
        <p style="margin-left: 100px;">Management</p>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center mt-5">
      <i class="bi bi-instagram me-5"> @bctweentyfour</i>
      <i class="bi bi-envelope mb-4">@bisniscenter24</i>
  </div>
</section>
<footer>
  <div class="d-flex justify-content-center mt-2 text-center">
    <i class="bi bi-c-circle mb-2 mt-1 me-3">Copyright 2025</i>
    <img src="../asset/logo_dupat-removebg-preview.png" style="width: 30px; height: 30px;">
  </div>
</footer>
</body>
</html>