<?php
    require_once'../koneksi/koneksi.php';
    
    function tambahAkun($username, $password, $email, $telepon, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = koneksi();
        $stmt = $conn->prepare("INSERT INTO akun (Username, Password, Email, Telepon, Role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hash, $email, $telepon, $role);
        if ($stmt->execute()) return $conn->insert_id;
        return false;
    }

    function updateAkun($id, $username, $email, $telepon, $role) {
        $conn = koneksi();
        $stmt = $conn->prepare("UPDATE akun SET Username=?, Email=?, Telepon=?, Role=? WHERE ID=?");
        $stmt->bind_param("ssssi", $username, $email, $telepon, $role, $id);
        return $stmt->execute();
    }

    function deleteAkun($id) {
        $conn = koneksi();
        $stmt = $conn->prepare("DELETE FROM akun WHERE ID=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    function tambahUser($nama, $kelas, $idAkun) {
        $conn = koneksi();
        $stmt = $conn->prepare("INSERT INTO user (Nama, Kelas, idAkun) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nama, $kelas, $idAkun);
        return $stmt->execute();
    }

    function updateUser($idUser, $nama, $kelas) {
        $conn = koneksi();
        $stmt = $conn->prepare("UPDATE user SET Nama=?, Kelas=? WHERE ID=?");
        $stmt->bind_param("ssi", $nama, $kelas, $idUser);
        return $stmt->execute();
    }

    function deleteUser($idUser) {
        $conn = koneksi();
        $stmt = $conn->prepare("SELECT idAkun FROM user WHERE ID=?");
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $idAkun = $result['idAkun'];
            $stmt = $conn->prepare("DELETE FROM user WHERE ID=?");
            $stmt->bind_param("i", $idUser);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM akun WHERE ID=?");
            $stmt->bind_param("i", $idAkun);
            $stmt->execute();
            $stmt->close();

            return true;
        }
        return false;
    }

    function getAllUserWithAkun() {
        $conn = koneksi();
        $sql = "SELECT user.ID, user.Nama, user.Kelas, user.idAkun, akun.Username, akun.Email, akun.Telepon
                FROM user JOIN akun ON user.idAkun = akun.ID WHERE akun.Role = 'User'";
        return $conn->query($sql);
    }

    function getAllAkunKasirDanAdmin() {
        $conn = koneksi();
        $sql = "SELECT ID, Username, Email, Telepon, Role FROM akun WHERE Role IN ('Kasir', 'Admin')";
        return $conn->query($sql);
    }

    function updatePasswordAkun($id, $passwordBaru) {
        $conn = koneksi();
        $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        $sql = "UPDATE akun SET Password = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hash, $id);
        return $stmt->execute();
    }

    function lupaPasswordAkun($email, $passwordBaru) {
        $conn = koneksi();
        $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        $sql = "UPDATE akun SET Password = ? WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hash, $email);
        return $stmt->execute();
    }

    
?>