<?php
require_once '../model/user.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
  header("Location: loginUser.php");
  exit;
}
$dataAkun = getAllAkunKasirDanAdmin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Manajemen Akun</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">+ Tambah Akun</button>

    <table class="table table-bordered table-striped">
        <thead class="table-secondary">
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
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditAkun<?= $row['ID'] ?>">Edit</button>
                    <a href="../controller/akun.php?hapus=<?= $row['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/akun.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="Admin">Admin</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                    </div>
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
            <form method="post" action="../controller/akun.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idAkun" value="<?= $row['ID'] ?>">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['Username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['Email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($row['Telepon']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="Admin" <?= $row['Role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="Kasir" <?= $row['Role'] == 'Kasir' ? 'selected' : '' ?>>Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>
</body>
</html>
