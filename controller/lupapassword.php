<?php
require_once '../koneksi/koneksi.php'; // sesuaikan dengan lokasi koneksi
require_once '../model/user.php'; // model yang berisi fungsi updatePasswordAkun()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $passwordBaru = $_POST['password'];

    if (lupaPasswordAkun($email, $passwordBaru)) {
        header("Location: ../app/loginUser.php?pesan=sukses");
    } else {
        header("Location: ../app/loginUser.php?pesan=gagal");
    }
}
