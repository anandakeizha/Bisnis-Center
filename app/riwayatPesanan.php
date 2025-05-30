<?php
require_once '../model/shop.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
  header("Location: loginUser.php");
  exit;
}

$idUser = $_SESSION['idUser'];
$resultPesanan = getPesananByUser($idUser);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Riwayat Pesanan</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f8;
        color: #2c3e50;
    }

    .orders-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto 40px;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 700;
        letter-spacing: 1.2px;
        color: #ffffff  ;
    }

    .order-card {
        background: #eaf6ff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        padding: 24px 30px;
        transition: box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .order-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    h2 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 8px;
    }

    p {
        margin: 6px 0 18px;
        font-size: 16px;
        color: #333;
    }

    strong {
        color: #218c74;
    }

    .table-wrapper {
        overflow-x: auto;
        margin-top: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        min-width: 350px;
        background-color: #fff;
    }

    thead {
        background-color: #2d8be8;
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    th, td {
        padding: 14px 20px;
        text-align: left;
        font-size: 15px;
        color: #2c3e50;
        white-space: nowrap;
    }

    tbody tr {
        background-color: #ffffff;
        border-bottom: 1.5px solid #e0e6ed;
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: #f0f8ff;
    }

    @media (max-width: 600px) {
        body {
            padding: 12px;
        }
        h1 {
            font-size: 24px;
        }
        h2 {
            font-size: 20px;
        }
        p, th, td {
            font-size: 14px;
        }
        .order-card {
            padding: 18px 20px;
        }
    }
</style>
</head>
<body>
    <h2 class="text-center fw-bold mb-4">Riwayat Pesanan</h2>

    <?php if ($resultPesanan->num_rows == 0): ?>
        <p class="no-orders">Tidak ada pesanan.</p>
    <?php else: ?>
        <div class="orders-container">  <!-- ini pembungkus grid -->

        <?php while ($pesanan = $resultPesanan->fetch_assoc()): ?>
            <div class="order-card">
                <h2>Pesanan <?= htmlspecialchars($pesanan['ID']) ?> {} <?= htmlspecialchars($pesanan['Tanggal']) ?></h2>
                <p>Status: <strong><?= htmlspecialchars($pesanan['Status']) ?></strong></p>
                <p>Total: Rp <?= number_format($pesanan['Total'], 0, ',', '.') ?></p>

                <?php
                $resultDetail = getDetailPesanan($pesanan['ID']);
                ?>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($detail = $resultDetail->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($detail['KodeBarang']) ?></td>
                                <td><?= htmlspecialchars($detail['Jumlah']) ?></td>
                                <td>Rp <?= number_format($detail['Total'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endwhile; ?>

        </div>
    <?php endif; ?>

</body>
</html>
