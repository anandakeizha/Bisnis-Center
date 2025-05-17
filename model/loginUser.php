<?php
    require_once '../koneksi/koneksi.php';
    function login($username, $password) {
        $conn = koneksi();
    
        $sql = "SELECT u.idAkun, a.Username, a.Role, u.ID, u.Nama
                FROM akun a
                LEFT JOIN user u ON a.ID = u.idAkun
                WHERE a.Username = ? AND a.Password = ?";
        
        $stmt = $conn->prepare($sql); // pakai $conn, bukan $this->conn
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }   

?>