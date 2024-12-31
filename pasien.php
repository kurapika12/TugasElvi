<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pasien</title>
    <!-- Bootstrap CSS -->
    <style>
        @import url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Manajemen Rumah Sakit</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="pasien.php">Pasien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dokter.php">Dokter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ruangan.php">Ruangan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kunjungan.php">Kunjungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="resep.php">Resep</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Manajemen Pasien</h2>

    <!-- Add/Edit Form -->
    <form method="POST" action="" class="mb-4">
        <?php
        include 'config.php';

        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM pasien WHERE id_pasien = $id";
            $conn->query($query);
            header("Location: pasien.php");
        }

        // Handle ADD or UPDATE request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_pasien = $_POST['id_pasien'] ?? null;
            $nama = $_POST['nama_pasien'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $alamat = $_POST['alamat'];
            $no_telepon = $_POST['no_telepon'];

            if ($id_pasien) {
                $query = "UPDATE pasien SET nama_pasien='$nama', tanggal_lahir='$tanggal_lahir', alamat='$alamat', no_telepon='$no_telepon' WHERE id_pasien=$id_pasien";
            } else {
                $query = "INSERT INTO pasien (nama_pasien, tanggal_lahir, alamat, no_telepon) VALUES ('$nama', '$tanggal_lahir', '$alamat', '$no_telepon')";
            }

            $conn->query($query);
            header("Location: pasien.php");
        }

        $editData = null;
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM pasien WHERE id_pasien = $id");
            $editData = $result->fetch_assoc();
        }
        ?>

        <input type="hidden" name="id_pasien" value="<?= $editData['id_pasien'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" name="nama_pasien" value="<?= $editData['nama_pasien'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" value="<?= $editData['tanggal_lahir'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" required><?= $editData['alamat'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" class="form-control" name="no_telepon" value="<?= $editData['no_telepon'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="pasien.php" class="btn btn-secondary">Batal</a>
    </form>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM pasien";
        $result = $conn->query($query);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_pasien']}</td>
                <td>{$row['tanggal_lahir']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['no_telepon']}</td>
                <td>
                    <a href='pasien.php?edit={$row['id_pasien']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='pasien.php?delete={$row['id_pasien']}' class='btn btn-danger btn-sm'>Hapus</a>
                </td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
