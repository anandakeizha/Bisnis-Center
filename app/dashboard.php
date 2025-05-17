<?php
session_start();
require_once '../model/shop.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
    
}

$items = getCartItems($idUser);
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
    /* Sidebar kanan */
    #cartSidebar {
      position: fixed;
      top: 0;
      right: -400px; /* sembunyikan awalnya */
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

    /* Header sidebar */
    #cartSidebar h3 {
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #000;
    }

    /* Tombol Close X */
    #closeCartBtn {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #333;
      line-height: 1;
    }

    /* Konten produk - scrollable */
    #cartItems {
      flex-grow: 1;
      overflow-y: auto;
      margin-bottom: 1rem;
    }

    /* Set gambar di cart */
    .cart-item-img {
      object-fit: cover;
      height: 100px;
      width: 100%;
      border-radius: 8px;
    }

    /* Kontrol jumlah */
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

    /* Tombol checkout di bawah selalu nempel */
    #checkoutBtn {
      width: 100%;
      flex-shrink: 0;
    }

    /* Overlay untuk tutup sidebar */
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

    /* --- RESPONSIVE --- */
    @media (max-width: 480px) {
      #cartSidebar {
        width: 100vw; /* full width di layar kecil */
        right: -100vw; /* sembunyikan di luar layar */
        padding: 1rem 0.5rem;
      }
      #cartSidebar.active {
        right: 0;
      }

      /* Perbesar tombol close */
      #closeCartBtn {
        font-size: 2rem;
      }

      /* Kontrol jumlah dan tombol hapus lebih besar */
      .quantity-controls button {
        width: 40px;
        height: 40px;
      }

      .quantity-controls span {
        font-size: 1.25rem;
        width: 40px;
        padding: 0 0.25rem;
      }

      /* Sesuaikan gambar agar tidak terlalu tinggi */
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
<body class="mb-2 bg-primary text-white">

  <nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex flex-row">
          <li class="nav-item mx-3">
            <a class="nav-link text-white" href="#home">Home</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link text-white" href="#about">About us</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link text-white" href="#service">Service</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link text-white" href="#contact">Contact us</a>
          </li>
          <?php if ($role == 'User'): ?>
            <li class="nav-item mx-3">
                <a class="nav-link text-white" href="shop.php">Shop</a>
            </li>    
          <?php endif; ?>
        </ul>
      </div>

      <div class="d-flex align-items-center gap-3">
        <!-- Tombol Cart dengan nama -->
        <?php if ($role == 'User'): ?>
          <button id="openCartBtn" class="btn btn-primary btn-lg d-flex align-items-center gap-2" title="Lihat Keranjang">
            <i class="bi bi-cart3 fs-4"></i> 
            <span><?php echo htmlspecialchars($username) ?></span>
          </button>
        <?php endif; ?>

        <!-- Logout -->
        <a href="../controller/prosesLogout.php" class="btn btn-light text-primary">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Overlay untuk klik diluar sidebar -->
  <div id="overlay" tabindex="-1"></div>

  <!-- Sidebar keranjang -->
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

    <a href="" class="btn btn-primary btn-lg" id="checkoutBtn" aria-label="Lanjutkan ke pembayaran">Checkout</a>
  </div>

  <script>
    const openCartBtn = document.getElementById('openCartBtn');
    const closeCartBtn = document.getElementById('closeCartBtn');
    const cartSidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('overlay');

    function openCart() {
      cartSidebar.classList.add('active');
      cartSidebar.setAttribute('aria-hidden', 'false');
      overlay.style.display = 'block';
      // Fokus ke tombol close untuk aksesibilitas
      closeCartBtn.focus();
    }

    function closeCart() {
      cartSidebar.classList.remove('active');
      cartSidebar.setAttribute('aria-hidden', 'true');
      overlay.style.display = 'none';
      openCartBtn.focus();
    }

    openCartBtn.addEventListener('click', openCart);
    closeCartBtn.addEventListener('click', closeCart);
    overlay.addEventListener('click', closeCart);

    // Tutup sidebar dengan tombol ESC
    document.addEventListener('keydown', function(e) {
      if (e.key === "Escape" && cartSidebar.classList.contains('active')) {
        closeCart();
      }
    });
  </script>
</body>
</html>
