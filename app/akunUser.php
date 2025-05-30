<?php
require_once '../model/user.php';
include "sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}
$dataUser = getAllUserWithAkun();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- UPGRADE: Tambah DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center">Manajemen User</h2>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah User</button>
    </div>

    <div class="table-responsive">
        <table id="tabelUser" class="table table-bordered table-striped align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $dataUser->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Nama']) ?></td>
                    <td><?= htmlspecialchars($row['Kelas']) ?></td>
                    <td><?= htmlspecialchars($row['Username']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= htmlspecialchars($row['Telepon']) ?></td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['ID'] ?>">Edit</button>
                        <a href="../controller/user.php?hapus=<?= $row['ID'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/user.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $fields = ['nama' => 'Nama', 'kelas' => 'Kelas', 'username' => 'Username', 'email' => 'Email', 'telepon' => 'Telepon', 'password' => 'Password'];
                    foreach ($fields as $name => $label):
                        $type = $name === 'email' ? 'email' : ($name === 'password' ? 'password' : 'text');
                    ?>
                        <div class="mb-3">
                            <label class="form-label"><?= $label ?></label>
                            <input type="<?= $type ?>" name="<?= $name ?>" class="form-control" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <?php $dataUser->data_seek(0); while ($row = $dataUser->fetch_assoc()): ?>
    <div class="modal fade" id="modalEdit<?= $row['ID'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/user.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idUser" value="<?= $row['ID'] ?>">
                    <input type="hidden" name="idAkun" value="<?= $row['idAkun'] ?>">

                    <?php
                    $editFields = [
                        'nama' => $row['Nama'],
                        'kelas' => $row['Kelas'],
                        'username' => $row['Username'],
                        'email' => $row['Email'],
                        'telepon' => $row['Telepon'],
                    ];
                    foreach ($editFields as $name => $value):
                        $type = $name === 'email' ? 'email' : 'text';
                    ?>
                        <div class="mb-3">
                            <label class="form-label"><?= ucfirst($name) ?></label>
                            <input type="<?= $type ?>" name="<?= $name ?>" class="form-control" value="<?= htmlspecialchars($value) ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- UPGRADE: Aktifkan DataTables -->
<script>
$(document).ready(function() {
    $('#tabelUser').DataTable({
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