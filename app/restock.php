<?php
require_once '../model/shop.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Kasir') {
  header("Location: loginUser.php");
  exit;
}
$result  = getProdukMenipis();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BC - Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0d6efd;
      color: white;
    }

    nav.navbar {
      margin-bottom: 20px;
    }

    .card {
      background-color: #e2eafc; /* lebih harmonis dengan bg utama */
      border-radius: 15px;
      border: none;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .card img {
      transition: transform 0.3s ease;
    }

    .card:hover img {
      transform: scale(1.05);
    }

    .card-body {
      padding: 1rem 1rem 0.5rem;
    }

    .card-hover {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: rgba(255,255,255,0.95);
      padding: 12px;
      display: none;
      border-top: 1px solid #dee2e6;
      transition: all 0.3s ease;
    }

    .card:hover .card-hover {
      display: block;
    }

    .btn-cart {
      background-color: #198754;
      color: white;
      border: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-cart:hover {
      background-color: #157347;
      transform: scale(1.03);
    }

    .form-control-sm {
      font-size: 0.9rem;
      padding: 0.3rem;
    }

    .card-title {
      font-weight: 600;
      margin-bottom: 0.3rem;
    }

    .card-text {
      font-size: 0.95rem;
      color: #212529;
    }

    .stock-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 2;
      font-size: 0.75rem;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <div class="row g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card shadow-sm h-100">
            <!-- Badge stok -->
            <span class="badge <?= $row['Stock'] <= 1 ? 'bg-danger' : 'bg-warning' ?> stock-badge">
              <?= $row['Stock'] >= 1 ? 'Stcok Menipis' : 'Stok Habis' ?>
            </span>

            <img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']) ?>"
                 class="card-img-top p-3"
                 style="height:200px; object-fit:contain;"
                 alt="<?= $row['NamaBarang'] ?>">

            <div class="card-body">
              <h5 class="card-title text-primary"><?= $row['NamaBarang'] ?></h5>
              <p class="card-text">Rp <?= number_format($row['HargaBarang'], 0, ',', '.') ?></p>
            </div>

            <?php if ($role == 'Kasir' && $row['Stock'] <= 5): ?>
              <div class="card-hover">
                <form action="../controller/addrestock.php" method="post">
                  <input type="hidden" name="idUser" value="<?= $idUser ?>">
                  <input type="hidden" name="kodeBarang" value="<?= $row['KodeBarang'] ?>">
                  <div class="mb-2">
                    <input type="number" name="jumlah" class="form-control form-control-sm" value="1" min="1">
                  </div>
                  <button type="submit" class="btn btn-cart btn-sm w-100">
                    <i class="bi bi-cart-plus"></i> Restock
                  </button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
