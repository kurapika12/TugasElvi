<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kunjungan</title>
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
    <h2>Manajemen Kunjungan</h2>

    <!-- Add/Edit Form -->
    <form method="POST" action="" class="mb-4">
        <?php
        include 'config.php';

        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM kunjungan WHERE id_kunjungan = $id";
            $conn->query($query);
            header("Location: kunjungan.php");
        }

        // Handle ADD or UPDATE request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_kunjungan = $_POST['id_kunjungan'] ?? null;
            $id_pasien = $_POST['id_pasien'];
            $id_dokter = $_POST['id_dokter'];
            $id_ruangan = $_POST['id_ruangan'];
            $tanggal_kunjungan = $_POST['tanggal_kunjungan'];

            if ($id_kunjungan) {
                $query = "UPDATE kunjungan SET id_pasien='$id_pasien', id_dokter='$id_dokter', id_ruangan='$id_ruangan', tanggal_kunjungan='$tanggal_kunjungan' WHERE id_kunjungan=$id_kunjungan";
            } else {
                $query = "INSERT INTO kunjungan (id_pasien, id_dokter, id_ruangan, tanggal_kunjungan) VALUES ('$id_pasien', '$id_dokter', '$id_ruangan', '$tanggal_kunjungan')";
            }

            $conn->query($query);
            header("Location: kunjungan.php");
        }

        $editData = null;
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM kunjungan WHERE id_kunjungan = $id");
            $editData = $result->fetch_assoc();
        }

        // Fetch options for pasien, dokter, and ruangan
        $pasienOptions = $conn->query("SELECT id_pasien, nama_pasien FROM pasien");
        $dokterOptions = $conn->query("SELECT id_dokter, nama_dokter FROM dokter");
        $ruanganOptions = $conn->query("SELECT id_ruangan, nama_ruangan FROM ruangan");
        ?>

        <input type="hidden" name="id_kunjungan" value="<?= $editData['id_kunjungan'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Pasien</label>
            <select class="form-control" name="id_pasien" required>
                <option value="">Pilih Pasien</option>
                <?php while ($row = $pasienOptions->fetch_assoc()): ?>
                    <option value="<?= $row['id_pasien'] ?>" <?= (isset($editData['id_pasien']) && $editData['id_pasien'] == $row['id_pasien']) ? 'selected' : '' ?>>
                        <?= $row['nama_pasien'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Dokter</label>
            <select class="form-control" name="id_dokter" required>
                <option value="">Pilih Dokter</option>
                <?php while ($row = $dokterOptions->fetch_assoc()): ?>
                    <option value="<?= $row['id_dokter'] ?>" <?= (isset($editData['id_dokter']) && $editData['id_dokter'] == $row['id_dokter']) ? 'selected' : '' ?>>
                        <?= $row['nama_dokter'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ruangan</label>
            <select class="form-control" name="id_ruangan" required>
                <option value="">Pilih Ruangan</option>
                <?php while ($row = $ruanganOptions->fetch_assoc()): ?>
                    <option value="<?= $row['id_ruangan'] ?>" <?= (isset($editData['id_ruangan']) && $editData['id_ruangan'] == $row['id_ruangan']) ? 'selected' : '' ?>>
                        <?= $row['nama_ruangan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Kunjungan</label>
            <input type="date" class="form-control" name="tanggal_kunjungan" value="<?= $editData['tanggal_kunjungan'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="kunjungan.php" class="btn btn-secondary">Batal</a>
    </form>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Ruangan</th>
            <th>Tanggal Kunjungan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT k.id_kunjungan, p.nama_pasien, d.nama_dokter, r.nama_ruangan, k.tanggal_kunjungan 
                  FROM kunjungan k 
                  JOIN pasien p ON k.id_pasien = p.id_pasien 
                  JOIN dokter d ON k.id_dokter = d.id_dokter
                  JOIN ruangan r ON k.id_ruangan = r.id_ruangan";
        $result = $conn->query($query);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_pasien']}</td>
                <td>{$row['nama_dokter']}</td>
                <td>{$row['nama_ruangan']}</td>
                <td>{$row['tanggal_kunjungan']}</td>
                <td>
                    <a href='kunjungan.php?edit={$row['id_kunjungan']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='kunjungan.php?delete={$row['id_kunjungan']}' class='btn btn-danger btn-sm'>Hapus</a>
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
