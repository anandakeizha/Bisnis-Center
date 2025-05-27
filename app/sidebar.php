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

    .dropdown-toggle::after {
      color: white;
    }
    </style>
</head>
<body>
<div class="sidebar bg-primary d-flex flex-column p-3">
    <h4 class="text-white mb-5" style="text-align: center; margin-top: 20px;">Dashboard</h4>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="dashboardAdmin.php" class="nav-link mb-4">Dashboard</a>
      </li>
      <li>
        <a href="pesanan.php" class="nav-link">Pesanan</a>
      </li>
      <li>
        <a href="detailPesanan.php" class="nav-link mt-4">Detail Pesanan</a>
      </li>
      <li>
        <a href="dataBarang.php" class="nav-link mt-4">Data Barang</a>
      </li>
      <li>
        <a href="akunUser.php" class="nav-link mt-4">Akun User</a>
      </li>
      <li>
        <a href="akunKasir.php" class="nav-link mt-4">Akun Kasir</a>
      </li>
      <li>
        <a href="akunAdmin.php" class="nav-link mt-4">Akun Admin</a>
      </li>
    </ul>
  </div>
</body>
</html>