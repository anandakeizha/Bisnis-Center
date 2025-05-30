<?php
include "sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Kasir') {
  header("Location: loginUser.php");
  exit;
}

require_once '../model/barang.php';
$jumlahKosong = getBarangMenipis();
$totalHariIni = getTotalHariIni();
$jumlahTransaksi = getJumlahTransaksiHariIni();
$produkTerlaris = getProdukTerlarisHariIni();
$pesananPending = getPesananPending();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['action'])){
      $id = $_POST['id'];
      $action = $_POST['action'];

      if ($action == 'Accept') {
          $status = 'Accept';
          echo "<script>
                  alert('Pesanan di Setujui!');
                  window.location.href = 'dashboardKasir.php';
                </script>";
      } elseif ($action == 'Cancel') {
          $status = 'Cancel';
          echo "<script>
                  alert('Pesanan diTolak!');
                  window.location.href = 'dashboardKasir.php';
                </script>";
      } else {
          $status = null;
      }

      if ($status !== null) {
          // Update status pesanan
          getUbahStatusPesanan($id, $status);

          // Jika statusnya Accept, kurangi stok
          if ($status === 'Accept') {
              kurangiStok($id);
          }
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-fluid mt-4">
  <br>

  <!-- Row 1 -->
  <div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
        <div class="card-body">
            <h5><i class="bi bi-wallet me-2"></i> Pendapatan hari ini</h5>
            <h3 class="text-success">Rp <?= number_format($totalHariIni, 0, ',', '.') ?></h3>
        </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
        <div class="card-body">
            <h5><i class="bi bi-box-seam-fill me-2"></i> Barang Stock Menipis</h5>
            <h3 class="mt-3"><?= $jumlahKosong ?></h3>
        </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
        <div class="card-body">
            <h5 class="card-title">Jumlah Transaksi Hari Ini</h5>
            <p class="card-text fs-3"><?= $jumlahTransaksi ?></p>
        </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
        <div class="card-body">
            <h5 class="card-title">Produk Terlaris Hari Ini</h5>
            <?php if ($produkTerlaris): ?>
            <p class="card-text fs-5"><?= htmlspecialchars($produkTerlaris['NamaBarang']) ?></p>
            <p class="text-muted">Terjual: <?= $produkTerlaris['total_terjual'] ?> pcs</p>
            <?php else: ?>
            <p class="card-text text-muted">Belum ada transaksi hari ini.</p>
            <?php endif; ?>
        </div>
        </div>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-12 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h4 class="mb-3 text-primary">Daftar Pesan Pending</h4>

          <?php while ($row = $pesananPending->fetch_assoc()): ?>
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-8 mb-3 mb-md-0">
                  <span class="badge bg-primary me-2">#<?= $row['ID'] ?></span>
                  <strong>Status:</strong>
                  <span class="text-dark me-3"><?= $row['Status'] ?></span>
                  <strong>Total:</strong>
                  <span class="text-dark"><?= $row['Total'] ?></span>
                </div>
                <div class="col-md-4 text-md-end">
                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                    <button type="submit" name="action" value="Accept" class="btn btn-success btn-sm me-2 mb-1">
                      <i class="bi bi-check-circle"></i> Accept
                    </button>
                  </form>

                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                    <button type="submit" name="action" value="Cancel" class="btn btn-danger btn-sm mb-1">
                      <i class="bi bi-x-circle"></i> Cancel
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>

        </div>
      </div>
    </div>
  </div>
</>
</body>
</html>
