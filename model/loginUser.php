<?php
    require_once '../koneksi/koneksi.php';
    function login($username, $password) {
        $conn = koneksi();

        // Ambil data berdasarkan username saja dulu
        $sql = "SELECT u.idAkun, a.Username, a.Password, a.Role, u.ID, u.Nama
                FROM akun a
                LEFT JOIN user u ON a.ID = u.idAkun
                WHERE a.Username = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $akun = $result->fetch_assoc();

        // Verifikasi password jika akun ditemukan
        if ($akun && password_verify($password, $akun['Password'])) {
            return $akun; // Password cocok, kirim data akun
        }

        return false; // Login gagal
    }

    function registerAkun($username, $password, $email, $telepon) {
        $conn = koneksi();
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO akun (Username, Password, Email, Telepon, Role) 
                VALUES (?, ?, ?, ?, 'User')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashedPassword, $email, $telepon);
        
        if ($stmt->execute()) {
            return $conn->insert_id; // kembalikan id akun yang baru
        } else {
            return false;
        }
    }

    function registerUser($nama, $kelas, $idAkun) {
        $conn = koneksi();

        $sql = "INSERT INTO user (Nama, Kelas, idAkun) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nama, $kelas, $idAkun);

        return $stmt->execute();
    }
?>