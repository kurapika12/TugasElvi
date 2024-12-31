<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Resep</title>
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
    <h2>Manajemen Resep</h2>

    <!-- Add/Edit Form -->
    <form method="POST" action="" class="mb-4">
        <?php
        include 'config.php';

        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM resep WHERE id_resep = $id";
            $conn->query($query);
            header("Location: resep.php");
        }

        // Handle ADD or UPDATE request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_resep = $_POST['id_resep'] ?? null;
            $id_kunjungan = $_POST['id_kunjungan'];
            $nama_obat = $_POST['nama_obat'];
            $dosis = $_POST['dosis'];

            if ($id_resep) {
                $query = "UPDATE resep SET id_kunjungan='$id_kunjungan', nama_obat='$nama_obat', dosis='$dosis' WHERE id_resep=$id_resep";
            } else {
                $query = "INSERT INTO resep (id_kunjungan, nama_obat, dosis) VALUES ('$id_kunjungan', '$nama_obat', '$dosis')";
            }

            $conn->query($query);
            header("Location: resep.php");
        }

        $editData = null;
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM resep WHERE id_resep = $id");
            $editData = $result->fetch_assoc();
        }

        // Fetch options for kunjungan
        $kunjunganOptions = $conn->query("SELECT k.id_kunjungan, p.nama_pasien, d.nama_dokter 
                                          FROM kunjungan k 
                                          JOIN pasien p ON k.id_pasien = p.id_pasien 
                                          JOIN dokter d ON k.id_dokter = d.id_dokter");
        ?>

        <input type="hidden" name="id_resep" value="<?= $editData['id_resep'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Kunjungan</label>
            <select class="form-control" name="id_kunjungan" required>
                <option value="">Pilih Kunjungan</option>
                <?php while ($row = $kunjunganOptions->fetch_assoc()): ?>
                    <option value="<?= $row['id_kunjungan'] ?>" <?= (isset($editData['id_kunjungan']) && $editData['id_kunjungan'] == $row['id_kunjungan']) ? 'selected' : '' ?>>
                        <?= $row['nama_pasien'] ?> - <?= $row['nama_dokter'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" class="form-control" name="nama_obat" value="<?= $editData['nama_obat'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Dosis</label>
            <input type="text" class="form-control" name="dosis" value="<?= $editData['dosis'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="resep.php" class="btn btn-secondary">Batal</a>
    </form>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Kunjungan</th>
            <th>Nama Obat</th>
            <th>Dosis</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT r.id_resep, p.nama_pasien, d.nama_dokter, r.nama_obat, r.dosis 
                  FROM resep r 
                  JOIN kunjungan k ON r.id_kunjungan = k.id_kunjungan 
                  JOIN pasien p ON k.id_pasien = p.id_pasien 
                  JOIN dokter d ON k.id_dokter = d.id_dokter";
        $result = $conn->query($query);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_pasien']} - {$row['nama_dokter']}</td>
                <td>{$row['nama_obat']}</td>
                <td>{$row['dosis']}</td>
                <td>
                    <a href='resep.php?edit={$row['id_resep']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='resep.php?delete={$row['id_resep']}' class='btn btn-danger btn-sm'>Hapus</a>
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
