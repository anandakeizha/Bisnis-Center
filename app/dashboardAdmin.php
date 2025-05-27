<?php
include "sidebar.php";
include "../koneksi/koneksi.php"
?>

<?php
$koneksi = koneksi();
$query_total = mysqli_query($koneksi, "SELECT SUM(Total) as total_pendapatan FROM pesanan");
$data_total = mysqli_fetch_assoc($query_total);
$total_pendapatan = $data_total['total_pendapatan'] ?? 0;
?>

<?php
$tanggal_hari_ini = date('Y-m-d');
$query_harian = mysqli_query($koneksi, "
    SELECT SUM(Total) as total_hari_ini
    FROM pesanan
    WHERE DATE(Tanggal) = '$tanggal_hari_ini'
");
$data_harian = mysqli_fetch_assoc($query_harian);
$total_hari_ini = $data_harian['total_hari_ini'] ?? 0;
?>

<?php
$query_stok = mysqli_query($koneksi, "SELECT COUNT(*) as stok_habis FROM barang WHERE Stock = 0");
$data_stok = mysqli_fetch_assoc($query_stok);
$stok_habis = $data_stok['stok_habis'] ?? 0;
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
</head>
<body>
  <div class="content">
    <h1>Dashboard</h1>
    <p>Dashboard detail Bisnis Center.</p>
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
          <div class="card shadow border border-0" style="width: 450px; height: 150px">
            <div class="card-body">
              <h5 style="text-align: left;"><i class="bi bi-currency-dollar"></i> Total Pendapatan</h5>
              <h3 class="mt-4 ms-1">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow border border-0" style="width: 450px; height: 150px">
            <div class="card-body">
              <h5 style="text-align: left;"><i class="bi bi-wallet me-2"></i> Total Pendapatan hari ini</h5>
              <h3 class="mt-4 ms-1">Rp <?= number_format($total_hari_ini, 0, ',', '.') ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow border border-0" style="width: 450px; height: 150px">
            <div class="card-body">
              <h5 style="text-align: left;"><i class="bi bi-box-seam-fill me-2"></i>  Stok Habis</h5>
              <h3 class="mt-4 ms-1"><?= $stok_habis ?> Barang</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-md-6 mb-4">
          <div class="card shadow border border-0" style="width: 685px; height: 400px">
            <div class="card-body">
            <h5 style="text-align: left;"><i class="bi bi-pie-chart-fill me-2"></i>  Produk Terlaris</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card shadow border border-0" style="width: 685px; height: 400px">
            <div class="card-body">
            <h5 style="text-align: left;"><i class="bi bi-bar-chart-fill"></i>  Grafik Penjualan</h5>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-md-6 mb-4">
          <div class="card shadow border border-0" style="width: 1400px; height: 240px">
            <div class="card-body">
              <h5 style="text-align: left;"><i class="bi bi-cash-coin me-4"></i> Transaksi Hari ini</h5>
              <table class="table table-hover">
                <tr>
                  <td>ID</td>
                  <td>Nama</td>
                  <td>Status</td>
                  <td>Total</td>
                  <td>Tanggal</td>
                </tr>
                <?php
                  $koneksi = koneksi();
                  $tanggal_hari_ini = date('Y-m-d');
                  $sql = "SELECT pesanan.ID, user.Nama, pesanan.Total, pesanan.Status, pesanan.Tanggal
                        FROM pesanan
                        JOIN user ON user.ID = pesanan.Id_User
                        WHERE DATE(Tanggal) = '$tanggal_hari_ini'";
                  $hasil = mysqli_query($koneksi, $sql);
                  if (!$hasil) {
                    echo "<tr><td colspan='5'>Query Error: " . mysqli_error($koneksi) . "</td></tr>";
                  } elseif (mysqli_num_rows($hasil) > 0) {
                    while ($row = mysqli_fetch_assoc($hasil)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Nama'] . "</td>";
                    echo "<td>" . $row['Total'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Tanggal'] . "</td>";
                    echo "</tr>";
                  }
                  } else {
                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                  }
                ?>
              </table>
              </div>
          </div>
        </div>
  </div>
</body>
</html>