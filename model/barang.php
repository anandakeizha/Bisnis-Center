<?php
require_once '../koneksi/koneksi.php';

function getAllBarang() {
    $conn = koneksi();
    return $conn->query("SELECT * FROM barang");
}

function tambahBarang($kodeBarang, $nama, $gambar, $stock, $harga) {
    $conn = koneksi();
    $stmt = $conn->prepare("INSERT INTO barang (kodeBarang, NamaBarang, gambar, Stock, HargaBarang) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("issii", $kodeBarang, $nama, $gambar, $stock, $harga);
    return $stmt->execute();
}

function getBarangById($id) {
    $conn = koneksi();
    $stmt = $conn->prepare("SELECT * FROM barang WHERE KodeBarang=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateBarang($id, $nama, $gambar, $stock, $harga, $updateGambar = true) {
    $conn = koneksi();
    if ($updateGambar) {
        $stmt = $conn->prepare("UPDATE barang SET NamaBarang=?, gambar=?, Stock=?, HargaBarang=? WHERE KodeBarang=?");
        $stmt->bind_param("ssiii", $nama, $gambar, $stock, $harga, $id);
    } else {
        $stmt = $conn->prepare("UPDATE barang SET NamaBarang=?, Stock=?, HargaBarang=? WHERE KodeBarang=?");
        $stmt->bind_param("siii", $nama, $stock, $harga, $id);
    }
    return $stmt->execute();
}

function deleteBarang($id) {
    $conn = koneksi();
    $stmt = $conn->prepare("DELETE FROM barang WHERE KodeBarang=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
