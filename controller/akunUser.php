<?php
require_once '../model/user.php';

// Tambah data user + akun
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];
    $telepon  = $_POST['telepon'];
    $nama     = $_POST['nama'];
    $kelas    = $_POST['kelas'];

    $idAkun = tambahAkun($username, $password, $email, $telepon, 'User');

    if ($idAkun) {
        tambahUser($nama, $kelas, $idAkun);
    }

    echo "<script>
                alert('Berhasil Tambah User');
                window.location.href = '../app/akunUser.php';
              </script>";
    exit;
}

// Edit data user + akun
if (isset($_POST['edit'])) {
    $idUser   = $_POST['idUser'];
    $idAkun   = $_POST['idAkun'];
    $nama     = $_POST['nama'];
    $kelas    = $_POST['kelas'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $telepon  = $_POST['telepon'];

    updateUser($idUser, $nama, $kelas);
    updateAkun($idAkun, $username, $email, $telepon, 'User');

    echo "<script>
            alert('Berhasil Edit User');
            window.location.href = '../app/akunUser.php';
          </script>";
    exit;
}

// Hapus user + akun
if (isset($_GET['hapus'])) {
    $idUser = $_GET['hapus'];
    deleteUser($idUser);

    echo "<script>
            alert('Berhasil Delete User');
            window.location.href = '../app/akunUser.php';
          </script>";
    exit;
}
