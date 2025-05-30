<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: loginUser.php");
    exit;
  }

if($_SESSION['role'] == "user"){
    header("Location: loginUser.php");
}

include "sidebar.php";
include "../koneksi/koneksi.php";
include "../controller/barang.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="content">
        <table class="table table-hover">
            <tr>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Image</td>
                <td>Stock</td>
                <td>Harga Barang</td>
                <td>Aksi</td>
            </tr>
            <?php
                $koneksi = koneksi();
                $sql = "SELECT * FROM barang";
                $hasil = mysqli_query($koneksi, $sql);
                if (!$hasil) {
                    echo "<tr><td colspan='5'>Query Error: " . mysqli_error($koneksi) . "</td></tr>";
                } elseif (mysqli_num_rows($hasil) > 0) {
                    while ($row = mysqli_fetch_assoc($hasil)) {
                        echo "<tr>";
                        echo "<td>" . $row['KodeBarang'] . "</td>";
                        echo "<td>" . $row['NamaBarang'] . "</td>";
                        echo "<td><img src='data:image/png;base64," . base64_encode($row['gambar']) . "' width='80'/></td>";
                        echo "<td>" . $row['Stock'] . "</td>";
                        echo "<td>" . $row['HargaBarang'] . "</td>";
                        echo "<td>";

                        if ($_SESSION['role'] == "Admin") {
                            echo "<button class='btn btn-warning text-white me-2' name='edit'>Edit</button>";
                            echo "<button class='btn btn-danger' name='delete'>Delete</button>";
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
        </table>
    </div>
</body>
</html>