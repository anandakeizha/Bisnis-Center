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

function updateBarang($id, $nama, $gambar, $harga, $updateGambar = true) {
    $conn = koneksi();
    if ($updateGambar) {
        $stmt = $conn->prepare("UPDATE barang SET NamaBarang=?, gambar=?, HargaBarang=? WHERE KodeBarang=?");
        $stmt->bind_param("ssii", $nama, $gambar, $harga, $id);
    } else {
        $stmt = $conn->prepare("UPDATE barang SET NamaBarang=?, HargaBarang=? WHERE KodeBarang=?");
        $stmt->bind_param("sii", $nama, $harga, $id);
    }
    return $stmt->execute();
}

function deleteBarang($id) {
    $conn = koneksi();
    $stmt = $conn->prepare("DELETE FROM barang WHERE KodeBarang=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getBarangKosong() {
    $conn = koneksi();
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM barang WHERE Stock = 0");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}

function getTotalHariIni() {
    $conn = koneksi();
    $query = "SELECT SUM(total) AS total_hari_ini FROM pesanan WHERE DATE(tanggal) = CURDATE()";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total_hari_ini'] ?? 0;
}

function getTotalKeseluruhan() {
    $conn = koneksi();
    $query = "SELECT SUM(total) AS total_keseluruhan FROM pesanan";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total_keseluruhan'] ?? 0;
}

function getJumlahTransaksiHariIni() {
    $conn = koneksi();
    $query = "SELECT COUNT(*) AS jumlah FROM pesanan WHERE DATE(tanggal) = CURDATE()";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['jumlah'] ?? 0;
    }
    return 0;
}

function getProdukTerlarisHariIni() {
    $conn = koneksi();
    $query = "
        SELECT p.NamaBarang, SUM(dt.Jumlah) AS total_terjual
        FROM detailpesanan dt
        JOIN pesanan t ON dt.idPesanan = t.id
        JOIN barang p ON dt.KodeBarang = p.KodeBarang
        WHERE DATE(t.tanggal) = CURDATE()
        GROUP BY dt.KodeBarang
        ORDER BY total_terjual DESC
        LIMIT 1
    ";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

function getBarangMenipis() {
    $conn = koneksi();
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM barang WHERE Stock <= 5");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}

?>
