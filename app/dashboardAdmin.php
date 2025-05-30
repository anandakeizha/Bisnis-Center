<?php
include "sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}

$conn = koneksi();
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';
$data = [];
if ($start && $end) {
    $startFormatted = mysqli_real_escape_string($conn, $start . " 00:00:00");
    $endFormatted = mysqli_real_escape_string($conn, $end . " 23:59:59");
    $query = "
        SELECT b.namaBarang, SUM(dp.Jumlah) as total_terjual
        FROM detailpesanan dp
        JOIN barang b ON dp.KodeBarang = b.KodeBarang
        JOIN pesanan p ON dp.idPesanan = p.id
        WHERE p.status = 'Accept'
        AND p.tanggal BETWEEN '$startFormatted' AND '$endFormatted'
        GROUP BY b.namaBarang
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['namaBarang']] = (int)$row['total_terjual'];
    }
}
$labels = json_encode(array_keys($data));
$values = json_encode(array_values($data));

require_once '../model/barang.php';
$jumlahKosong = getBarangKosong();
$totalHariIni = getTotalHariIni();
$totalKeseluruhan = getTotalKeseluruhan();

$pesanPending = getPesanPending();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['Aksi'])){
      $id = $_POST['id'];
      $action = $_POST['Aksi'];

      if ($action == 'Confirm') {
          $status = 'Confirm';
          echo "<script>
                  alert('Pesanan di Setujui!');
                  window.location.href = 'dashboardAdmin.php';
                </script>";
      } elseif ($action == 'Cancel') {
          $status = 'Cancel';
          echo "<script>
                  alert('Pesanan diTolak!');
                  window.location.href = 'dashboardAdmin.php';
                </script>";
      } else {
          $status = null;
      }

      if ($status !== null) {
          // Update status pesanan
          getUbahStatusPesan($id, $status);

          // Jika statusnya Accept, kurangi stok
          if ($status === 'Confirm') {
              TambahStok($id);
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
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-currency-dollar me-2"></i> Total Revenue</h5>
          <h3 class="text-primary">Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-wallet me-2"></i> Pendapatan hari ini</h5>
          <h3 class="text-success">Rp <?= number_format($totalHariIni, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5><i class="bi bi-box-seam-fill me-2"></i> Barang Habis</h5>
          <h3 class="mt-3"><?= $jumlahKosong ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-12 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h4 class="mb-3 text-primary">Daftar Pesan Pending</h4>

          <?php while ($row = $pesanPending->fetch_assoc()): ?>
            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-8 mb-3 mb-md-0 text-break">
                    <span class="badge bg-primary me-2">#<?= htmlspecialchars($row['ID']) ?></span>
                    <span class="text-dark"><?= htmlspecialchars($row['Pesan']) ?></span>
                  </div>
                  <div class="col-md-4 text-md-end">
                    <form method="POST" class="d-inline">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($row['ID']) ?>">
                      <button type="submit" name="Aksi" value="Confirm" class="btn btn-success btn-sm me-2 mb-1">
                        <i class="bi bi-check-circle"></i> Accept
                      </button>
                    </form>

                    <form method="POST" class="d-inline">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($row['ID']) ?>">
                      <button type="submit" name="Aksi" value="Cancel" class="btn btn-danger btn-sm mb-1">
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


  <!-- Row Grafik Penjualan -->
  <div class="row mt-2">
    <div class="col-12 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h4 class="text-center">Diagram Batang Laporan Penjualan</h4>
          <form method="GET" class="row g-3 justify-content-center mb-4">
            <div class="col-md-4">
              <label class="form-label">Dari:</label>
              <input type="date" name="start" value="<?= htmlspecialchars($start) ?>" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Sampai:</label>
              <input type="date" name="end" value="<?= htmlspecialchars($end) ?>" class="form-control">
            </div>
            <div class="col-md-2 align-self-end">
              <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
            </div>
          </form>

          <?php if ($start && $end): ?>
            <div style="height: 400px;">
              <canvas id="penjualanChart"></canvas>
            </div>
            <script>
              const ctx = document.getElementById('penjualanChart').getContext('2d');
              new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: <?= $labels ?>,
                  datasets: [{
                    label: 'Jumlah Terjual',
                    data: <?= $values ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                  }]
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    y: {
                      beginAtZero: true,
                      title: {
                        display: true,
                        text: 'Jumlah'
                      }
                    },
                    x: {
                      title: {
                        display: true,
                        text: 'Produk'
                      }
                    }
                  },
                  plugins: {
                    legend: {
                      display: true
                    }
                  }
                }
              });
            </script>
          <?php elseif ($_GET): ?>
            <p class="text-danger text-center">Silakan pilih rentang tanggal yang lengkap untuk menampilkan data.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
