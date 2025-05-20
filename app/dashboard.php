<?php
session_start();
require_once '../model/shop.php';

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
    elseif(isset($_POST['action'])){
      $id = $_POST['id'];
      $action = $_POST['action'];

      if ($action == 'Accept') {
          $status = 'Accept';
          echo "<script>
                  alert('Pesanan di Setujui!');
                  window.location.href = 'dashboard.php';
                </script>";
      } elseif ($action == 'Cancel') {
          $status = 'Cancel';
          echo "<script>
                  alert('Pesanan diTolak!');
                  window.location.href = 'dashboard.php';
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
    }elseif(isset($_POST['Aksi'])){
      $id = $_POST['id'];
      $action = $_POST['Aksi'];

      if ($action == 'Confirm') {
          $status = 'Confirm';
          echo "<script>
                  alert('Pesanan di Setujui!');
                  window.location.href = 'dashboard.php';
                </script>";
      } elseif ($action == 'Cancel') {
          $status = 'Cancel';
          echo "<script>
                  alert('Pesanan diTolak!');
                  window.location.href = 'dashboard.php';
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

$items = getCartItems($idUser);

if ($role == 'Kasir'){
  $pesananPending = getPesananPending();
}

if ($role == 'Admin'){
  $pesanPending = getPesanPending();
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
  <style>
    body {
      padding-left: 250px; /* Adjust based on sidebar width */
      min-height: 100vh;
      background-color: #f8f9fa;
      transition: padding-left 0.3s;
    }
    
    /* Sidebar styles */
    #mainSidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background-color: #0d6efd;
      color: white;
      z-index: 1000;
      overflow-y: auto;
      transition: transform 0.3s;
    }
    
    .sidebar-brand {
      padding: 1rem;
      font-size: 1.2rem;
      font-weight: bold;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      text-align: center;
    }
    
    .sidebar-nav {
      padding: 0;
      list-style: none;
    }
    
    .sidebar-nav .nav-item {
      margin: 0;
    }
    
    .sidebar-nav .nav-link {
      color: white;
      padding: 0.75rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      transition: background-color 0.2s;
    }
    
    .sidebar-nav .nav-link:hover {
      background-color: rgba(0, 0, 0, 0.15);
    }
    
    .sidebar-nav .nav-link.active {
      background-color: rgba(0, 0, 0, 0.15);
    }
    
    .sidebar-footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      padding: 1rem;
      border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    /* Cart sidebar styles (kept from original) */
    #cartSidebar {
      position: fixed;
      top: 0;
      right: -400px;
      width: 400px;
      max-width: 100vw;
      height: 100vh;
      background: #fff;
      box-shadow: -4px 0 15px rgba(0,0,0,0.3);
      overflow-y: auto;
      transition: right 0.3s ease;
      z-index: 1051;
      display: flex;
      flex-direction: column;
      padding: 1rem;
      color: #000;
    }
    
    #cartSidebar.active {
      right: 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      body {
        padding-left: 0;
      }
      
      #mainSidebar {
        transform: translateX(-100%);
      }
      
      #mainSidebar.active {
        transform: translateX(0);
      }
    }
    
    /* Main content area */
    .main-content {
      padding: 20px;
      background-color: white;
      min-height: calc(100vh - 56px);
    }
    
    /* Keep original cart styles */
    #cartSidebar h3 {
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #000;
    }
    
    #closeCartBtn {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #333;
      line-height: 1;
    }
    
    #cartItems {
      flex-grow: 1;
      overflow-y: auto;
      margin-bottom: 1rem;
    }
    
    .cart-item-img {
      object-fit: cover;
      height: 100px;
      width: 100%;
      border-radius: 8px;
    }
    
    .quantity-controls button {
      width: 32px;
      height: 32px;
      padding: 0;
    }
    
    .quantity-controls span {
      display: inline-block;
      width: 30px;
      text-align: center;
      font-weight: 600;
      font-size: 1rem;
    }
    
    #checkoutBtn {
      width: 100%;
      flex-shrink: 0;
    }
    
    #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0,0,0,0.5);
      display: none;
      z-index: 1050;
    }
    
    @media (max-width: 480px) {
      #cartSidebar {
        width: 100vw;
        right: -100vw;
        padding: 1rem 0.5rem;
      }
      #cartSidebar.active {
        right: 0;
      }
      #closeCartBtn {
        font-size: 2rem;
      }
      .quantity-controls button {
        width: 40px;
        height: 40px;
      }
      .quantity-controls span {
        font-size: 1.25rem;
        width: 40px;
        padding: 0 0.25rem;
      }
      .cart-item-img {
        height: 80px;
      }
    }
    
    @media (min-width: 481px) and (max-width: 767px) {
      #cartSidebar {
        width: 320px;
        right: -320px;
      }
      #cartSidebar.active {
        right: 0;
      }
    }
  </style>
</head>
<body class="bg-primary text-black">

<!-- Main Sidebar -->
<div id="mainSidebar">
  <div class="sidebar-brand">
    <?php echo htmlspecialchars($username) ?>
  </div>
  
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" href="#home">
        <i class="bi bi-house"></i> Home
      </a>
    </li>
    <?php if ($role == 'User'): ?>
      <li class="nav-item">
        <a class="nav-link text-white" href="#shop">
          <i class="bi bi-shop"></i> Shop
        </a>
      </li>    
      <li class="nav-item">
        <a class="nav-link text-white" href="#riwayat">
          <i class="bi bi-clock-history"></i> History
        </a>
      </li>    
    <?php endif; ?>
    <?php if ($role == 'Kasir'): ?>
      <li class="nav-item">
        <a class="nav-link text-white" href="#restock">
          <i class="bi bi-box-seam"></i> Stock
        </a>
      </li>    
    <?php endif; ?>
    <?php if ($role == 'Admin'): ?>
      <li class="nav-item">
        <a class="nav-link text-white" href="#user">
          <i class="bi bi-person"></i> User
        </a>
      </li>    
      <li class="nav-item">
        <a class="nav-link text-white" href="#akun">
          <i class="bi bi-person-circle"></i> Akun
        </a>
      </li>    
      <li class="nav-item">
        <a class="nav-link text-white" href="#barang  ">
          <i class="bi bi-box-seam"></i> Barang
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#laporanPenjualan">
          <i class="bi bi-bar-chart"></i> Laporan Penjualan
        </a>
      </li>
    <?php endif; ?>
  </ul>
  
  <div class="sidebar-footer">
    <a href="../controller/prosesLogout.php" class="btn btn-light text-primary w-100">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
  
</div>

<!-- Mobile navbar toggle -->
<nav class="navbar d-lg-none navbar-dark bg-primary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" id="sidebarToggle">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Main Content -->
<div class="main-content">
  <section class="bg-white py-2" id="home">
    <?php if ($role == 'User'): ?>
      <button id="openCartBtn" class="btn btn-primary d-flex align-items-center gap-2" title="Lihat Keranjang">
        <i class="bi bi-cart3 fs-4"></i> 
      </button>
    <?php endif; ?>

    <?php if ($role == 'Kasir'): ?>
      <div class="container mt-4">
        <h4 class="mb-3 text-primary">Daftar Pesanan Pending</h4>
        
        <?php while ($row = $pesananPending->fetch_assoc()): ?>
          <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
              <div class="mb-2 mb-md-0">
                <span class="badge bg-primary me-2">#<?= $row['ID'] ?></span>
                <strong>Status:</strong> 
                <span class="text-dark"><?= $row['Status'] ?></span>
                <strong>Total:</strong> 
                <span class="text-dark"><?= $row['Total'] ?></span>
              </div>
              
              <div>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                  <button type="submit" name="action" value="Accept" class="btn btn-success btn-sm me-2">
                    <i class="bi bi-check-circle"></i> Accept
                  </button>
                </form>

                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                  <button type="submit" name="action" value="Cancel" class="btn btn-danger btn-sm">
                    <i class="bi bi-x-circle"></i> Cancel
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

    <?php if ($role == 'Admin'): ?>
      <div class="container mt-4">
        <h4 class="mb-3 text-primary">Daftar Pesan Pending</h4>
        
        <?php while ($row = $pesanPending->fetch_assoc()): ?>
          <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
              <div class="mb-2 mb-md-0">
                <span class="badge bg-primary me-2">#<?= $row['ID'] ?></span>
                <span class="text-dark"><?= $row['Pesan'] ?></span>
              </div>
              
              <div>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                  <button type="submit" name="Aksi" value="Confirm" class="btn btn-success btn-sm me-2">
                    <i class="bi bi-check-circle"></i> Accept
                  </button>
                </form>

                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                  <button type="submit" name="Aksi" value="Cancel" class="btn btn-danger btn-sm">
                    <i class="bi bi-x-circle"></i> Cancel
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </section>

  <?php if ($role == 'User'): ?>
    <section class="bg-white py-2" id="shop">
        <?php include 'shop.php'; ?>
    </section>
    <section class="bg-white py-2" id="riwayat">
        <?php include 'riwayatpesanan.php'; ?>
    </section>
  <?php endif; ?>

  <?php if ($role == 'Kasir'): ?>
    <section class="bg-white py-2" id="restock">
        <?php include 'restock.php'; ?>
    </section>
  <?php endif; ?>

  <?php if ($role == 'Admin'): ?>
    <section class="bg-white text-dark py-2" id="user">
        <?php include 'user.php'; ?>
    </section>
    <section class="bg-white text-dark py-2" id="akun">
        <?php include 'akun.php'; ?>
    </section>
    <section class="bg-white text-dark py-2" id="barang">
        <?php include 'barang.php'; ?>
    </section>
    <section class="bg-white text-dark py-2" id="laporanPenjualan">
        <?php include 'laporan.php'; ?>
    </section>
  <?php endif; ?>

</div>

<!-- Cart Sidebar (same as before) -->
<div id="overlay" tabindex="-1"></div>

<div id="cartSidebar" role="dialog" aria-modal="true" aria-labelledby="cartTitle" aria-hidden="true">
  <h3 id="cartTitle">
    Keranjang Belanja Anda
    <button id="closeCartBtn" aria-label="Tutup keranjang">&times;</button>
  </h3>

  <div id="cartItems">
    <?php if ($items->num_rows === 0): ?>
      <p>Keranjang kosong.</p>
    <?php else: ?>
      <?php while ($row = $items->fetch_assoc()): ?>
        <div class="card mb-3 shadow-sm border-0">
          <div class="row g-0">
            <div class="col-4">
              <img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']) ?>" alt="<?= htmlspecialchars($row['NamaBarang']) ?>" class="cart-item-img" />
            </div>
            <div class="col-8">
              <div class="card-body p-2">
                <h6 class="card-title"><?= htmlspecialchars($row['NamaBarang']) ?></h6>
                <p class="card-text mb-1 text-success fw-bold">Rp<?= number_format($row['TotalHarga']) ?></p>

                <form method="POST" action="" class="d-flex align-items-center quantity-controls" style="gap: 0.5rem;">
                  <input type="hidden" name="kodeBarang" value="<?= $row['KodeBarang'] ?>" />
                  <input type="hidden" name="jumlah" value="<?= $row['Jumlah'] ?>" />
                  <button type="submit" class="btn btn-outline-secondary btn-sm" name="update" value="minus" aria-label="Kurangi jumlah"><i class="bi bi-dash"></i></button>
                  <span><?= $row['Jumlah'] ?></span>
                  <button type="submit" class="btn btn-outline-secondary btn-sm" name="update" value="plus" aria-label="Tambah jumlah"><i class="bi bi-plus"></i></button>
                </form>

                <form method="POST" action="" class="mt-2">
                  <input type="hidden" name="kodeBarang" value="<?= $row['KodeBarang'] ?>" />
                  <button type="submit" class="btn btn-danger btn-sm w-100" name="delete" value="delete" aria-label="Hapus item">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>

  <a href="../controller/checkout.php" class="btn btn-primary btn-lg" id="checkoutBtn" aria-label="Lanjutkan ke pembayaran">Checkout</a>
</div>

<script>
  // Sidebar toggle functionality
  const sidebarToggle = document.getElementById('sidebarToggle');
  const mainSidebar = document.getElementById('mainSidebar');
  
  sidebarToggle?.addEventListener('click', function() {
    mainSidebar.classList.toggle('active');
  });
  
  document.addEventListener('click', function(e) {
  if (
    window.innerWidth <= 992 && 
    !mainSidebar.contains(e.target) && 
    !sidebarToggle.contains(e.target)
  ) {
    mainSidebar.classList.remove('active');
  }
});


  // Cart functionality (same as before)
  const openCartBtn = document.getElementById('openCartBtn');
  const closeCartBtn = document.getElementById('closeCartBtn');
  const cartSidebar = document.getElementById('cartSidebar');
  const overlay = document.getElementById('overlay');

  function openCart() {
    cartSidebar.classList.add('active');
    cartSidebar.setAttribute('aria-hidden', 'false');
    overlay.style.display = 'block';
    closeCartBtn.focus();
  }

  function closeCart() {
    cartSidebar.classList.remove('active');
    cartSidebar.setAttribute('aria-hidden', 'true');
    overlay.style.display = 'none';
    if (openCartBtn) openCartBtn.focus();
  }

  openCartBtn?.addEventListener('click', openCart);
  closeCartBtn.addEventListener('click', closeCart);
  overlay.addEventListener('click', closeCart);

  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape" && cartSidebar.classList.contains('active')) {
      closeCart();
    }
  });
</script>
</body>
</html>
