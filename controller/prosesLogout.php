<?php
session_start();
session_unset(); // Hapus semua variabel session
session_destroy(); // Hancurkan session

echo "<script>
        alert('Logout berhasil!');
        window.location.href = '../app/loginUser.php'; // arahkan ke form login
      </script>";
?>