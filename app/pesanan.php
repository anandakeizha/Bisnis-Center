<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: loginUser.php");
    exit;
  }

if($_SESSION['role'] == "user"):
  header("Location: loginUser.php");
endif;
include "sidebar.php";
include "../koneksi/koneksi.php"
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
                <td>ID</td>
                <td>Nama</td>
                <td>Status</td>
                <td>Total</td>
                <td>Tanggal</td>
            </tr>
            <?php
                $koneksi = koneksi();
                $sql = "SELECT pesanan.ID, user.Nama, pesanan.Total, pesanan.Status, pesanan.Tanggal
                        FROM pesanan
                        JOIN user ON user.ID = pesanan.Id_User";
                $hasil = mysqli_query($koneksi, $sql);
                if (!$hasil) {
                    echo "<tr><td colspan='5'>Query Error: " . mysqli_error($koneksi) . "</td></tr>";
                } elseif (mysqli_num_rows($hasil) > 0) {
                    while ($row = mysqli_fetch_assoc($hasil)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Nama'] . "</td>";
                    echo "<td>" . $row['Total'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Tanggal'] . "</td>";
                    echo "</tr>";
                }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                }
            ?>
        </table>
    </div>
</body>
</html>