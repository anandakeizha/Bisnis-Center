<?php
session_start();
$role = $_SESSION['role'];
?>
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
    body {
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 250px;
      position: sticky;
    }
    .sidebar .nav-link {
      color: #fff;
    }
    .sidebar .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
    }

    .sidebar .dropdown-menu {
      background-color: #0d6efd;
      border: none;
    }

    .sidebar .dropdown-item {
      color: white;
    }

    .sidebar .dropdown-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar .dropdown-item{
      background-color: white;
      color: black;
    }

    .sidebar .dropdown-menu{
      border-radius: 25px;
    }

    .dropdown-toggle::after {
      color: white;
    }

    </style>
</head>
<body>
<div class="sidebar bg-primary d-flex flex-column p-3">
    <img src="../asset/Logobcputih1.png" class="mb-5 ms-3 align-items-center" style="width: 150px;">
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="dashboardAdmin.php" class="nav-link mb-4"><i class="bi bi-clipboard-data me-4"></i>Dashboard</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-cash-coin me-4"></i>Transaksi
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="pesanan.php">Pesanan</a></li>
          <li><a class="dropdown-item" href="detailPesanan.php">Detail Pesanan</a></li>
        </ul>
      </li>
      <li>
        <a href="dataBarang.php" class="nav-link mt-4"><i class="bi bi-box-seam-fill me-4"></i>Data Barang</a>
      </li>
      <?php if($_SESSION['role'] == "Admin"): ?>
      <li class="nav-item dropdown mt-4">
        <a class="nav-link dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-file-person-fill me-4"></i>Data Akun
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="akunUser.php">User</a></li>
          <li><a class="dropdown-item" href="akunKasir.php">Kasir</a></li>
        </ul>
      </li>
      <?php endif ?>
    </ul>
    <a href="loginUser.php" class="btn btn-light text-primary mt-auto mb-3"><i class="bi bi-box-arrow-left color-primary me-2 align-items-center"></i> Logout</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>