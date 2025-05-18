<?php
require_once '../koneksi/koneksi.php';
session_start();

$idUser = $_SESSION['idUser'];

$conn = koneksi();

// Ambil item dari cart milik user
$sqlCart = "SELECT * FROM cart WHERE IdUser = ?";
$stmtCart = $conn->prepare($sqlCart);
$stmtCart->bind_param("i", $idUser);
$stmtCart->execute();
$resultCart = $stmtCart->get_result();

$items = [];
$totalAll = 0;

while ($row = $resultCart->fetch_assoc()) {
    $items[] = $row;
    $totalAll += $row['TotalHarga'];
}

// Insert ke tabel pesanan
$sqlPesanan = "INSERT INTO pesanan (Id_User, Total, Status) VALUES (?, ?, 'Pending')";
$stmtPesanan = $conn->prepare($sqlPesanan);
$stmtPesanan->bind_param("ii", $idUser, $totalAll);
$stmtPesanan->execute();

$idPesananBaru = $conn->insert_id; // ambil id pesanan terakhir

// Insert ke tabel detail_pesanan
$sqlDetail = "INSERT INTO detailpesanan (idPesanan, KodeBarang, Jumlah, Total) VALUES (?, ?, ?, ?)";
$stmtDetail = $conn->prepare($sqlDetail);


foreach ($items as $item) {
    $stmtDetail->bind_param("iiii", $idPesananBaru, $item['KodeBarang'], $item['Jumlah'], $item['TotalHarga']);
    $stmtDetail->execute();
}


// Hapus data cart usera
$deleteCart = $conn->prepare("DELETE FROM cart WHERE IdUser = ?");
$deleteCart->bind_param("i", $idUser);
$deleteCart->execute();

// Redirect atau notifikasi
// echo "<script>
//         alert('Checkout berhasil!');
//         window.location.href = '../app/riwayatPesanan.php';
//       </script>";

echo "<script>
        alert('Checkout berhasil!');
        window.location.href = '../app/shop.php';
      </script>";
?>
