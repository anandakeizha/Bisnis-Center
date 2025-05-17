<?php
session_start();
require_once '../model/loginUser.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "Username dan password wajib diisi!";
        return;
    }

    $akun = login($username, $password);

    if ($akun) {
        $_SESSION['idAkun'] = $akun['idAkun'];
        $_SESSION['username'] = $akun['Username'];
        $_SESSION['role'] = $akun['Role'];
        $_SESSION['idUser'] = $akun['ID'] ?? null;

        echo "<script>
                alert('Login berhasil!');
                window.location.href = '../app/dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Login gagal. Username atau password salah.');
                window.history.back();
              </script>";
    }
}
?>
