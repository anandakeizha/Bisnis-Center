<?php
require_once '../model/barang.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}
$dataBarang = getAllBarang();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Manajemen Barang</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">+ Tambah Barang</button>

    <table class="table table-bordered table-striped">
        <thead class="table-secondary">
            <tr>
                <th>Nama Barang</th>
                <th>Gambar</th>
                <th>Stock</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $dataBarang->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['NamaBarang']) ?></td>
                <td><img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']) ?>" width="100"></td>
                <td><?= $row['Stock'] ?></td>
                <td>Rp <?= number_format($row['HargaBarang']) ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditBarang<?= $row['KodeBarang'] ?>">Edit</button>
                    <a href="../controller/barang.php?hapus=<?= $row['KodeBarang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1">
        <div class="modal-dialog">
            <form method="post" enctype="multipart/form-data" action="../controller/barang.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                     <div class="mb-3"><label>kode Barang</label><input type="text" name="kodeBarang" class="form-control" maxlength="10" required></div>
                    <div class="mb-3"><label>Nama Barang</label><input type="text" name="nama" class="form-control" required></div>
                    <div class="mb-3"><label>Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*" required></div>
                    <div class="mb-3"><label>Stock</label><input type="number" name="stock" class="form-control" required></div>
                    <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <?php
    $dataBarang->data_seek(0);
    while ($row = $dataBarang->fetch_assoc()):
    ?>
    <div class="modal fade" id="modalEditBarang<?= $row['KodeBarang'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <form method="post" enctype="multipart/form-data" action="../controller/barang.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['KodeBarang'] ?>">
                    <div class="mb-3"><label>Nama Barang</label><input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['NamaBarang']) ?>" required></div>
                    <div class="mb-3"><label>Gambar (Kosongkan jika tidak ingin diubah)</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label>Stock</label><input type="number" name="stock" class="form-control" value="<?= $row['Stock'] ?>" required></div>
                    <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" value="<?= $row['HargaBarang'] ?>" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endwhile; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
