<?php
require_once '../model/shop.php';
include 'sidebar.php';

if (!isset($_SESSION['username'])) {
    header("Location: loginUser.php");
    exit;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
if ($role == 'User') {
    $idUser = $_SESSION['idUser'];
} else {
    $idUser = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
</head>
<body>

<div class="container mt-4">
  <div class="row">
    <!-- Total Transaksi -->
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-receipt-cutoff me-2"></i> Total Transaksi</h5>
          <h3><?= getTotalTransaksiUser($idUser) ?></h3>
        </div>
      </div>
    </div>

    <!-- Pengeluaran Bulan Ini -->
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-wallet2 me-2"></i> Pengeluaran Bulan Ini</h5>
          <h3 class="text-danger">Rp <?= number_format(getPengeluaranBulanIni($idUser), 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>

    <!-- Produk Favorit -->
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-star-fill me-2"></i> Produk Favorit</h5>
          <?php $favorit = getProdukFavoritUser($idUser); ?>
          <?php if ($favorit): ?>
            <p><?= $favorit['nama_produk'] ?></p>
            <p class="text-muted">Dibeli: <?= $favorit['jumlah'] ?>x</p>
          <?php else: ?>
            <p class="text-muted">Belum ada transaksi.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
