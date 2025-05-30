<?php
require_once '../model/user.php';

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];
    $telepon  = $_POST['telepon'];
    $role     = $_POST['role'];

    $id = tambahAkun($username, $password, $email, $telepon, $role);
    echo "<script>
                alert('Berhasil Tambah Akun');
                window.location.href = '../app/akunKasir.php';
              </script>";
    exit;
}

if (isset($_POST['edit'])) {
    $id       = $_POST['idAkun'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $telepon  = $_POST['telepon'];
    $role     = $_POST['role'];

    updateAkun($id, $username, $email, $telepon, $role);
    echo "<script>
                alert('Berhasil Edit Akun');
                window.location.href = '../app/akunKasir.php';
              </script>";
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    deleteAkun($id);
    echo "<script>
                alert('Berhasil Delete Akun');
                window.location.href = '../app/akunKasir.php';
              </script>";
    exit;
}
