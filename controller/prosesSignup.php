<?php
require_once '../model/loginUser.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    $idAkun = registerAkun($username, $password, $email, $telepon);
    if ($idAkun) {
        if (registerUser($nama, $kelas, $idAkun)) {
            echo "<script>
                alert('Register berhasil!');
                window.location.href = '../app/loginUser.php';
              </script>";
        } else {
            return "Gagal menyimpan data user.";
        }
    } else {
        return "Gagal menyimpan data akun.";
    }
}
?>
