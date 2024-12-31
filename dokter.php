<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dokter</title>
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
    <h2>Manajemen Dokter</h2>

    <!-- Add/Edit Form -->
    <form method="POST" action="" class="mb-4">
        <?php
        include 'config.php';

        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM dokter WHERE id_dokter = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: dokter.php");
        }

        // Handle ADD or UPDATE request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_dokter = $_POST['id_dokter'] ?? null;
            $nama = $_POST['nama_dokter'];
            $spesialisasi = $_POST['spesialisasi'];
            $no_telepon = $_POST['no_telepon'];

            if ($id_dokter) {
                $query = "UPDATE dokter SET nama_dokter = ?, spesialisasi = ?, no_telepon = ? WHERE id_dokter = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssi", $nama, $spesialisasi, $no_telepon, $id_dokter);
            } else {
                $query = "INSERT INTO dokter (nama_dokter, spesialisasi, no_telepon) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $nama, $spesialisasi, $no_telepon);
            }

            $stmt->execute();
            header("Location: dokter.php");
        }

        // Edit data for update
        $editData = null;
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM dokter WHERE id_dokter = $id");
            $editData = $result->fetch_assoc();
        }
        ?>

        <input type="hidden" name="id_dokter" value="<?= $editData['id_dokter'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Nama Dokter</label>
            <input type="text" class="form-control" name="nama_dokter" value="<?= $editData['nama_dokter'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Spesialisasi</label>
            <input type="text" class="form-control" name="spesialisasi" value="<?= $editData['spesialisasi'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" class="form-control" name="no_telepon" value="<?= $editData['no_telepon'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dokter.php" class="btn btn-secondary">Batal</a>
    </form>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Spesialisasi</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM dokter";
        $result = $conn->query($query);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_dokter']}</td>
                <td>{$row['spesialisasi']}</td>
                <td>{$row['no_telepon']}</td>
                <td>
                    <a href='dokter.php?edit={$row['id_dokter']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='dokter.php?delete={$row['id_dokter']}' class='btn btn-danger btn-sm'>Hapus</a>
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
