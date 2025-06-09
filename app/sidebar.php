<?php
session_start();
require_once '../model/shop.php';

if (!isset($_SESSION['username'])) {
    header("Location: loginUser.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$idUser = ($role == 'User') ? $_SESSION['idUser'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $kodeBarang = $_POST['kodeBarang'];
        $jumlah = $_POST['jumlah'];

        if ($_POST['update'] === 'plus') {
            $jumlah += 1;
        } elseif ($_POST['update'] === 'minus' && $jumlah > 1) {
            $jumlah -= 1;
        }
        updateCartQuantity($idUser, $kodeBarang, $jumlah);
    } elseif (isset($_POST['delete'])) {
        $kodeBarang = $_POST['kodeBarang'];
        deleteCartItem($idUser, $kodeBarang);
    }
}

$items = ($role == 'User') ? getCartItems($idUser) : null;

$conn = koneksi();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body { min-height: 100vh; display: flex; background-color: #f1f3f5; font-family: 'Segoe UI', sans-serif; }
    .sidebar { background-color: #0d6efd; width: 250px; padding: 2rem 1rem; color: white; position: sticky; top: 0; height: 100vh; }
    .sidebar .nav-link { color: white; }
    .sidebar .nav-link:hover { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar .dropdown-menu { background-color: #0d6efd; border: none; border-radius: 15px; }
    .sidebar .dropdown-item { color: white; }
    .sidebar .dropdown-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    .content { flex-grow: 1; padding: 2rem; background-color: #f8f9fa; }

    /* Cart styles */
    #cartSidebar { position: fixed; right: -100%; top: 0; width: 350px; height: 100%; background: white; box-shadow: -2px 0 10px rgba(0,0,0,0.15); z-index: 1050; padding: 1rem; transition: right 0.3s; border-left: 5px solid #0d6efd; overflow-y: auto; }
    #cartSidebar.active { right: 0; }
    #overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.3); z-index: 1049; }
    .cart-item-img { width: 100%; height: 100px; object-fit: cover; border-radius: 8px; }
    .quantity-controls button { border-radius: 5px; }
    #cartTitle {
      font-size: 1.25rem; /* Ukuran judul lebih kecil */
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #closeCartBtn {
      font-size: 0.9rem;
      width: 1.5rem;
      height: 1.5rem;
    }

    .sidebar {
      transition: transform 0.3s ease;
    }

    #burgerBtn {
      position: fixed;
      top: 10px;
      left: 10px;
      z-index: 1100;
      width: 45px;
      height: 45px;
      padding: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }



    /* Di layar kecil, sidebar di geser keluar */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background-color: #0d6efd;
        transform: translateX(-100%);
        z-index: 1051;
      }
      .sidebar.active {
        transform: translateX(0);
      }
    }


  </style>
</head>
<body>

<!-- Tombol burger yang hanya muncul di layar kecil -->
<button id="burgerBtn" class="btn btn-primary d-md-none" type="button" aria-label="Toggle sidebar">
  <i class="bi bi-list fs-3"></i>
</button>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column">
  <div class="d-flex align-items-center justify-content-between mb-4 ms-3 me-3">
    <img src="../asset/Logobcputih1.png" style="width: 130px;">
    <?php if ($role == 'User'): ?>
      <button id="openCartBtn" class="btn btn-light text-primary ms-4">
        <i class="bi bi-cart3 fs-5"></i>
      </button>
    <?php endif; ?>
  </div>


  <ul class="nav nav-pills flex-column mb-auto">
    <?php if ($role == 'Admin'): ?>
      <li class="nav-item"><a href="dashboardAdmin.php" class="nav-link"><i class="bi bi-clipboard-data me-3"></i>Dashboard</a></li>
      <li><a href="dataBarang.php" class="nav-link"><i class="bi bi-box-seam-fill me-3"></i>Data Barang</a></li>
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-file-person-fill me-2"></i> Data Akun
        </a>
        <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="akunAdmin.php">Admin</a></li>
          <li><a class="dropdown-item" href="akunUser.php">User</a></li>
          <li><a class="dropdown-item" href="akunKasir.php">Kasir</a></li>
        </ul>
      </div>
    <?php elseif ($role == 'Kasir'): ?>
      <li><a class="nav-link" href="dashboardKasir.php"><i class="bi bi-house me-3"></i>Home</a></li>
      <li><a class="nav-link" href="restock.php"><i class="bi bi-box-seam me-3"></i>Stock Menipis</a></li>
    <?php elseif ($role == 'User'): ?>
      <li><a class="nav-link" href="dashboard.php"><i class="bi bi-house me-3"></i>Home</a></li>
      <li><a class="nav-link" href="shop.php"><i class="bi bi-shop me-3"></i>Shop</a></li>
      <li><a class="nav-link" href="riwayatPesanan.php"><i class="bi bi-clock-history me-3"></i>History</a></li>
    <?php endif; ?>
  </ul>
  <a href="../controller/prosesLogout.php" class="btn btn-light text-primary mt-auto mb-3"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
</div>

<?php if ($role == 'User'): ?>
<?php
  $idUser = $_SESSION['idUser']; // Pastikan sudah login dan ada session idUser
  $adaYangMelebihiStok = false;

  // Ambil seluruh keranjang milik user beserta stok dan data barang
  $queryCart = mysqli_query($conn, "SELECT cart.*, barang.Stock, barang.gambar, barang.NamaBarang, barang.HargaBarang 
                                    FROM cart 
                                    JOIN barang ON cart.KodeBarang = barang.KodeBarang 
                                    WHERE cart.IdUser = '$idUser'");

  $cartItems = [];
  while ($row = mysqli_fetch_assoc($queryCart)) {
    $kodeBarang = $row['KodeBarang'];

    // Hitung total jumlah di keranjang untuk produk ini (user ini)
    $jumlahCart = $row['Jumlah'];

    // Hitung total jumlah di pesanan belum selesai untuk produk ini
    $queryOrder = mysqli_query($conn, "
      SELECT SUM(dp.Jumlah) AS totalPesanan
      FROM detailpesanan dp
      JOIN pesanan p ON dp.idPesanan = p.ID
      WHERE dp.KodeBarang = '$kodeBarang'
      AND p.Status != 'Accept'");
    $dataOrder = mysqli_fetch_assoc($queryOrder);
    $totalPesanan = $dataOrder['totalPesanan'] ?? 0;

    // Hitung stok tersisa yang tersedia untuk ditambahkan ke keranjang
    $stokTersedia = $row['Stock'] - $totalPesanan;

    // Pastikan stok tersisa minimal 0
    if ($stokTersedia < 0) $stokTersedia = 0;

    // Cek apakah jumlah melebihi stok tersisa (stok sudah habis)
    if ($jumlahCart > $stokTersedia) {
      $adaYangMelebihiStok = true;
    }

    // Simpan data stok tersisa dan jumlahCart untuk tombol plus/minus nanti
    $row['stokTersedia'] = $stokTersedia;
    $cartItems[] = $row;
  }
?>

<!-- Sidebar Cart -->
<div id="overlay" tabindex="-1"></div>
<div id="cartSidebar" role="dialog" aria-modal="true" aria-hidden="true">
  <h3 id="cartTitle">Keranjang Belanja Anda
    <button id="closeCartBtn" class="btn-close float-end" aria-label="Tutup keranjang"></button>
  </h3>
  <div id="cartItems">
    <?php if (empty($cartItems)): ?>
      <p>Keranjang kosong.</p>
    <?php else: ?>
      <?php foreach ($cartItems as $item): ?>
        <?php
          $kodeBarang = $item['KodeBarang'];
          $jumlah = $item['Jumlah'];
          $stokTersedia = $item['stokTersedia'];
          $totalHarga = $jumlah * $item['HargaBarang'];

          // Tombol plus disable jika stok tersisa <= 0 atau jumlah sudah sama dengan stok tersisa
          $disablePlus = ($stokTersedia <= 0 || $jumlah >= $stokTersedia);

          // Tombol minus disable jika jumlah <= 1 (gak boleh kurang dari 1)
          $disableMinus = ($jumlah <= 1);
        ?>
        <div class="card mb-3 border-0 shadow-sm">
          <div class="row g-0">
            <div class="col-4">
              <img src="data:image/jpeg;base64,<?= base64_encode($item['gambar']) ?>" class="cart-item-img" alt="<?= htmlspecialchars($item['NamaBarang']) ?>">
            </div>
            <div class="col-8">
              <div class="card-body p-2">
                <h6 class="card-title"><?= htmlspecialchars($item['NamaBarang']) ?></h6>
                <p class="text-success fw-bold">Rp<?= number_format($totalHarga) ?></p>

                <form method="POST" class="d-flex align-items-center quantity-controls mb-2" style="gap: 0.5rem;">
                  <input type="hidden" name="kodeBarang" value="<?= $kodeBarang ?>">
                  <input type="hidden" name="jumlah" value="<?= $jumlah ?>">

                  <button type="submit" name="update" value="minus" class="btn btn-outline-secondary btn-sm" <?= $disableMinus ? 'disabled' : '' ?>>
                    <i class="bi bi-dash"></i>
                  </button>

                  <span><?= $jumlah ?></span>

                  <button type="submit" name="update" value="plus" class="btn btn-outline-secondary btn-sm" <?= $disablePlus ? 'disabled' : '' ?>>
                    <i class="bi bi-plus"></i>
                  </button>
                </form>

                <form method="POST">
                  <input type="hidden" name="kodeBarang" value="<?= $kodeBarang ?>">
                  <button type="submit" name="delete" value="delete" class="btn btn-danger btn-sm w-100">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Tombol checkout disable jika ada jumlah di keranjang yang melebihi stok -->
  <a href="../controller/checkout.php" class="btn btn-primary btn-lg w-100 mt-3 <?= $adaYangMelebihiStok ? 'disabled' : '' ?>">Checkout</a>
</div>
<?php endif; ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>

  const burgerBtn = document.getElementById('burgerBtn');
  const sidebar = document.querySelector('.sidebar');

  burgerBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });

  // Cart Sidebar Toggle
  const openCartBtn = document.getElementById('openCartBtn');
  const closeCartBtn = document.getElementById('closeCartBtn');
  const cartSidebar = document.getElementById('cartSidebar');
  const overlay = document.getElementById('overlay');

  function openCart() {
    cartSidebar.classList.add('active');
    overlay.style.display = 'block';
  }

  function closeCart() {
    cartSidebar.classList.remove('active');
    overlay.style.display = 'none';
  }

  if (openCartBtn) openCartBtn.addEventListener('click', openCart);
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
  if (overlay) overlay.addEventListener('click', closeCart);
  
</script>
</body>
</html>
