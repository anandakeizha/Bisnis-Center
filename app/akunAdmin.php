<?php
require_once '../model/user.php';
include "sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}
$dataAkun = getAllAkunAdmin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Akun</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center">Manajemen Akun</h2>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">+ Tambah Akun</button>
    </div>

    <!-- Tabel Responsif -->
    <div class="table-responsive">
        <table id="tabelAkun" class="table table-bordered table-striped align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $dataAkun->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Username']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= htmlspecialchars($row['Telepon']) ?></td>
                    <td><?= htmlspecialchars($row['Role']) ?></td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditAkun<?= $row['ID'] ?>">Edit</button>
                        <a href="../controller/akunAdmin.php?hapus=<?= $row['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/akunAdmin.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Telepon</label><input type="text" name="telepon" class="form-control" required></div>
                    <input type="hidden" name="role" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <?php
    $dataAkun->data_seek(0);
    while ($row = $dataAkun->fetch_assoc()):
    ?>
    <div class="modal fade" id="modalEditAkun<?= $row['ID'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/akunAdmin.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idAkun" value="<?= $row['ID'] ?>">
                    <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['Username']) ?>" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['Email']) ?>" required></div>
                    <div class="mb-3"><label>Telepon</label><input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($row['Telepon']) ?>" required></div>
                    <input type="hidden" name="role" class="form-control" value="<?= htmlspecialchars($row['Role']) ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (DataTables requirement) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelAkun').DataTable({
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
