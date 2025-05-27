<?php
require_once '../koneksi/koneksi.php'; // sesuaikan dengan lokasi koneksi
require_once '../model/user.php'; // model yang berisi fungsi updatePasswordAkun()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $passwordBaru = $_POST['password'];

    if (updatePasswordAkun($id, $passwordBaru)) {
        header("Location: ../app/dashboard.php?pesan=sukses");
    } else {
        header("Location: ../app/dashboard.php?pesan=gagal");
    }
}
