<?php
require_once'../model/shop.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    // $idUser = $_POST['idUser'];  // Ideally get the user ID from the session
    $idUser = $_POST['idUser']; // Hardcoded user ID for now, you can retrieve from session
    $kodeBarang = $_POST['kodeBarang'];
    $jumlah = $_POST['jumlah'];

    // Validate input
    if (empty($idUser) || empty($kodeBarang) || empty($jumlah)) {
        echo "All fields are required!";
        return;
    }

    if (addToCart($kodeBarang, $idUser, $jumlah)) {
        echo "<script>
                alert('Item successfully added to cart!');
                window.history.back();
              </script>";
    } else {
        echo "<script>
                alert('Failed to add item to cart!');
                window.history.back();
              </script>";
    }
    
}
?>
