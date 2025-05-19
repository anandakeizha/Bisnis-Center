<?php
require_once '../model/user.php';
$dataUser = getAllUserWithAkun();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Manajemen User</h2>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah User</button>

    <!-- Tabel -->
    <table class="table table-bordered table-striped">
        <thead class="table-secondary">
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
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['ID'] ?>">Edit</button>
                    <a href="../controller/user.php?hapus=<?= $row['ID'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Tambah (pindah ke sini, di luar tabel) -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../controller/user.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
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
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit (pindah ke sini juga) -->
    <?php
    // Reset pointer dataUser kalau perlu looping ulang modal edit
    $dataUser->data_seek(0);
    while ($row = $dataUser->fetch_assoc()):
    ?>
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

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['Nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($row['Kelas']) ?>" required>
                    </div>
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
