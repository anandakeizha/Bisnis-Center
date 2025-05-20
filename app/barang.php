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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center">Manajemen Barang</h2>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">+ Tambah Barang</button>
    </div>

    <!-- Tabel Responsif -->
    <div class="table-responsive">
        <table  id="tabelBarang" class="table table-bordered table-striped align-middle">
            <thead class="table-secondary text-center">
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
                    <td><img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']) ?>" class="img-fluid" style="max-width: 100px;"></td>
                    <td><?= $row['Stock'] ?></td>
                    <td>Rp <?= number_format($row['HargaBarang']) ?></td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditBarang<?= $row['KodeBarang'] ?>">Edit</button>
                        <a href="../controller/barang.php?hapus=<?= $row['KodeBarang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1">
        <div class="modal-dialog">
            <form method="post" enctype="multipart/form-data" action="../controller/barang.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>Kode Barang</label><input type="text" name="kodeBarang" class="form-control" maxlength="10" required></div>
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
                    <div class="mb-3"><label>Gambar (kosongkan jika tidak diubah)</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
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
<!-- jQuery (DataTables requirement) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelBarang').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });
});
</script>
</body>
</html>