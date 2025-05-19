<?php
require_once'../model/shop.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $kodeBarang = $_POST['kodeBarang'];
    $jumlah = $_POST['jumlah'];
    $status = "Pending";
    $pesan = "Saya membutuhkan barang dengan kode barang $kodeBarang sebanyak $jumlah";

    if (addPesan($kodeBarang,$pesan, $jumlah, $status)) {
        echo "<script>
                alert('Item successfully added to cart!');
                window.location.href = '../app/dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to add item to cart!');
                window.history.back();
              </script>";
    }
    
}
?>
