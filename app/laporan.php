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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        form label {
            font-weight: bold;
        }

        form input[type="date"], form button {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        form button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

        .chart-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 10px;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }

        @media (max-width: 600px) {
            form {
                flex-direction: column;
                align-items: stretch;
            }

            form input[type="date"], form button {
                width: 100%;
            }
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
    <p style="text-align:center; color:red;">Silakan pilih rentang tanggal yang lengkap untuk menampilkan data.</p>
<?php endif; ?>

</body>
</html>
