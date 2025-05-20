<?php

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}


$conn = koneksi();

$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';

$data = [];

if ($start && $end) {
    // Tambahkan waktu untuk batas awal dan akhir hari
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
        display: block;
        width: 100%;
        text-align: center;
        margin-bottom: 30px;
        }

        form label {
            display: inline-block;
            margin: 0 10px;
            font-weight: bold;
        }

        form input[type="date"] {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        form button {
            padding: 6px 14px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>

<h2>Diagram Batang Laporan Penjualan</h2>

<form method="GET">
    <label>Dari: <input type="date" name="start" value="<?= htmlspecialchars($start) ?>"></label>
    <label>Sampai: <input type="date" name="end" value="<?= htmlspecialchars($end) ?>"></label>
    <button type="submit">Tampilkan</button>
</form>

<?php if ($start && $end): ?>
<div class="chart-container">
    <canvas id="penjualanChart"></canvas>
</div>
<script>
    const ctx = document.getElementById('penjualanChart').getContext('2d');
    const penjualanChart = new Chart(ctx, {
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
            }
        }
    });
</script>
<?php elseif ($_GET): ?>
    <p style="text-align:center; color:red;">Silakan pilih rentang tanggal yang lengkap untuk menampilkan data.</p>
<?php endif; ?>

</body>
</html>
