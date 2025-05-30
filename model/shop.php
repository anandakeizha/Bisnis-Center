<?php
    require_once '../koneksi/koneksi.php';
    function getProduk(){
        $conn = koneksi();
        $result = $conn->query("SELECT * FROM barang");
        return $result;
    }

    function checkIfItemExists($idUser, $kodeBarang) {
        $conn = koneksi();
        $stmt = $conn->prepare("SELECT * FROM cart WHERE IdUser = ? AND KodeBarang = ?");
        $stmt->bind_param("ii", $idUser, $kodeBarang);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }    

    function removeFromCart($idUser, $kodeBarang) {
        $conn = koneksi();
        $stmt = $conn->prepare("DELETE FROM cart WHERE IdUser = ? AND KodeBarang = ?");
        $stmt->bind_param("ii", $idUser, $kodeBarang);
        $stmt->execute();
    }

    function getCartItems($idUser) {
        $conn = koneksi();
        $stmt = $conn->prepare("
            SELECT c.*, b.NamaBarang, b.HargaBarang, b.gambar
            FROM cart c
            JOIN barang b ON c.KodeBarang = b.KodeBarang
            WHERE c.IdUser = ?
        ");
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    function addToCart($kodeBarang, $idUser, $jumlah) {
        $conn = koneksi();
    
        // Ambil harga satuan barang
        $stmt = $conn->prepare("SELECT HargaBarang FROM barang WHERE KodeBarang = ?");
        $stmt->bind_param("i", $kodeBarang);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $harga = $row['HargaBarang'];
            $totalBaru = $harga * $jumlah;
        } else {
            return false; // Barang tidak ditemukan
        }
    
        if (checkIfItemExists($idUser, $kodeBarang)) {
            // Update jumlah dan total harga
            $stmt = $conn->prepare("UPDATE cart 
                SET Jumlah = Jumlah + ?, TotalHarga = TotalHarga + ? 
                WHERE IdUser = ? AND KodeBarang = ?");
            $stmt->bind_param("ddii", $jumlah, $totalBaru, $idUser, $kodeBarang);
        } else {
            // Insert data baru
            $stmt = $conn->prepare("INSERT INTO cart (KodeBarang, IdUser, Jumlah, TotalHarga) 
                VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $kodeBarang, $idUser, $jumlah, $totalBaru);
        }
    
        return $stmt->execute(); // return true jika berhasil, false jika gagal
    }    
    
    function removeOutOfStockItems() {
        $conn = koneksi();
        
        // Get all cart items with their KodeBarang
        $stmt = $conn->prepare("SELECT KodeBarang FROM cart");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($item = $result->fetch_assoc()) {
            $kodeBarang = $item['KodeBarang'];
    
            // Check stock for each product in the cart
            $stmtCheckStock = $conn->prepare("SELECT Stock FROM barang WHERE KodeBarang = ?");
            $stmtCheckStock->bind_param("i", $kodeBarang);
            $stmtCheckStock->execute();
            $stockResult = $stmtCheckStock->get_result();
            $product = $stockResult->fetch_assoc();
    
            // If stock is 0, remove the item from the cart
            if ($product['Stock'] <= 0) {
                $stmtRemove = $conn->prepare("DELETE FROM cart WHERE KodeBarang = ?");
                $stmtRemove->bind_param("i", $kodeBarang);
                $stmtRemove->execute();
            }
        }
    }
  
    // Fungsi untuk update jumlah barang di keranjang
    function updateCartQuantity($idUser, $kodeBarang, $jumlah) {
        $conn = koneksi();
        
        // Ambil harga barang berdasarkan KodeBarang
        $stmt = $conn->prepare("SELECT HargaBarang FROM barang WHERE KodeBarang = ?");
        $stmt->bind_param("i", $kodeBarang);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Jika barang tidak ditemukan, berhenti
        if (!$row) {
            return;
        }
    
        $hargaBarang = $row['HargaBarang'];
        
        // Jika jumlah = 0, hapus barang dari keranjang
        if ($jumlah == 0) {
            deleteCartItem($idUser, $kodeBarang);
            return;
        }
        
        // Hitung total harga berdasarkan jumlah dan harga barang
        $totalHarga = $jumlah * $hargaBarang;
        
        // Update jumlah dan total harga barang di keranjang
        $stmt = $conn->prepare("UPDATE cart SET Jumlah = ?, TotalHarga = ? WHERE IdUser = ? AND KodeBarang = ?");
        $stmt->bind_param("iiii", $jumlah, $totalHarga, $idUser, $kodeBarang);
        $stmt->execute();
    }
    
    
    // Menghapus barang dari keranjang
    function deleteCartItem($idUser, $kodeBarang) {
        $conn = koneksi();
        
        // Hapus item dari keranjang berdasarkan KodeBarang dan IdUser
        $stmt = $conn->prepare("DELETE FROM cart WHERE IdUser = ? AND KodeBarang = ?");
        $stmt->bind_param("ii", $idUser, $kodeBarang);
        $stmt->execute();
    }

    function getPesananByUser($idUser) {
        $conn = koneksi();

        $sql = "SELECT * FROM pesanan WHERE Id_User = ? ORDER BY Tanggal DESC";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        return $stmt->get_result();  // wajib return hasil query
    }

    function getDetailPesanan($idPesanan) {
        $conn = koneksi();

        $sql = "SELECT * FROM detailpesanan WHERE idPesanan = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $idPesanan);
        $stmt->execute();
        return $stmt->get_result();  // wajib return hasil query
    }

    function getPesananPending() {
        $conn = koneksi();

        $sql = "SELECT * FROM pesanan WHERE Status = 'Pending'";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->execute();
        return $stmt->get_result();  // wajib return hasil query
    }

    function getUbahStatusPesanan($idPesanan, $statusBaru) {
        $conn = koneksi();

        $sql = "UPDATE pesanan SET status = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $statusBaru, $idPesanan);
        $stmt->execute();

    }

   function kurangiStok($idPesanan) {
        $conn = koneksi();

        // Ambil detail pesanan
        $result = getDetailPesanan($idPesanan);

        if (!$result) {
            die("Gagal mengambil detail pesanan.");
        }

        while ($row = $result->fetch_assoc()) {
            $kodeBarang = $row['KodeBarang'];
            $jumlah = (int)$row['Jumlah'];

            // Ambil stok sekarang
            $sqlCek = "SELECT Stock FROM barang WHERE KodeBarang = ?";
            $stmtCek = $conn->prepare($sqlCek);
            $stmtCek->bind_param("s", $kodeBarang);
            $stmtCek->execute();
            $stmtCek->bind_result($stokSekarang);
            $stmtCek->fetch();
            $stmtCek->close();

            // Hitung stok baru, jangan sampai negatif
            $stokBaru = max(0, $stokSekarang - $jumlah);

            // Update stok
            $sqlUpdate = "UPDATE barang SET Stock = ? WHERE KodeBarang = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            if (!$stmtUpdate) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtUpdate->bind_param("is", $stokBaru, $kodeBarang);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }
    }


    function getProdukMenipis(){
        $conn = koneksi();
        $result = $conn->query("SELECT * FROM barang where Stock <= 5");
        return $result;
    }


    function getPesanPending() {
        $conn = koneksi();

        $sql = "SELECT * FROM pesan WHERE Status = 'Pending'";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->execute();
        return $stmt->get_result();  // wajib return hasil query
    }

    function getUbahStatusPesan($idPesanan, $statusBaru) {
        $conn = koneksi();

        $sql = "UPDATE pesan SET status = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $statusBaru, $idPesanan);
        $stmt->execute();

    }

    function addPesan($kodeBarang, $pesan, $jumlah, $status){
        $conn = koneksi();
        $stmt = $conn->prepare("INSERT INTO pesan (KodeBarang, Pesan, Jumlah, Status) 
                VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $kodeBarang, $pesan, $jumlah, $status);
            return $stmt->execute();
    }

    function getPesan($idPesanan) {
        $conn = koneksi();

        $sql = "SELECT * FROM pesan WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $idPesanan);
        $stmt->execute();
        return $stmt->get_result();  // wajib return hasil query
    }

    function TambahStok($idPesanan) {
        $conn = koneksi();

        getPesan($idPesanan);

        $sql = "SELECT KodeBarang, Jumlah FROM pesan WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPesanan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Data pesanan tidak ditemukan.");
        }

        $row = $result->fetch_assoc();
        $kodeBarang = $row['KodeBarang'];
        $jumlah = $row['Jumlah'];

        // Tambah ke stok barang
        $sqlUpdateStok = "UPDATE barang SET stock = stock + ? WHERE kodebarang = ?";
        $stmtStok = $conn->prepare($sqlUpdateStok);
        $stmtStok->bind_param("is", $jumlah, $kodeBarang);
        $stmtStok->execute();
    }

    function getTotalTransaksiUser($idUser) {
        $conn = koneksi();
        $query = "SELECT COUNT(*) as total_transaksi FROM pesanan WHERE id_User = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total_transaksi'] ?? 0;
    }

    function getPengeluaranBulanIni($idUser) {
        $conn = koneksi();
        $query = "SELECT SUM(total) as total_bulan FROM pesanan
                WHERE id_User = ? AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total_bulan'] ?? 0;
    }

    function getProdukFavoritUser($idUser) {
        $conn = koneksi();
        $query = "SELECT b.NamaBarang AS nama_produk, SUM(dt.jumlah) AS jumlah 
                FROM detailpesanan dt 
                JOIN pesanan t ON dt.idPesanan = t.ID 
                JOIN barang b ON dt.KodeBarang = b.KodeBarang
                WHERE t.id_User = ?
                GROUP BY dt.KodeBarang
                ORDER BY jumlah DESC 
                LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

?>