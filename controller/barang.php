<?php
require_once '../model/barang.php';

if (isset($_POST['tambah'])) {
    $kodeBarang = $_POST['kodeBarang'];
    $nama = $_POST['nama'];
    $stock = 0;
    $harga = $_POST['harga'];
    $gambar = file_get_contents($_FILES['gambar']['tmp_name']);

    tambahBarang($kodeBarang, $nama, $gambar, $stock, $harga);
    echo "<script>
                alert('Berhasil Tambah Barang');
                window.location.href = '../app/barang.php';
              </script>";
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $updateGambar = isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0;
    $gambar = $updateGambar ? file_get_contents($_FILES['gambar']['tmp_name']) : null;

    updateBarang($id, $nama, $gambar,  $harga, $updateGambar);
    echo "<script>
                alert('Berhasil Edit Barang');
                window.location.href = '../app/barang.php';
              </script>";
    exit;
}

if (isset($_GET['hapus'])) {
    deleteBarang($_GET['hapus']);
    echo "<script>
                alert('Berhasil Delete Barang');
                window.location.href = '../app/barang.php';
              </script>";
    exit;
}
?>
