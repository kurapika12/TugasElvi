<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ruangan</title>
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
    <h2>Manajemen Ruangan</h2>

    <!-- Add/Edit Form -->
    <form method="POST" action="" class="mb-4">
        <?php
        include 'config.php';

        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM ruangan WHERE id_ruangan = $id";
            $conn->query($query);
            header("Location: ruangan.php");
        }

        // Handle ADD or UPDATE request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_ruangan = $_POST['id_ruangan'] ?? null;
            $nama_ruangan = $_POST['nama_ruangan'];
            $kapasitas = $_POST['kapasitas'];

            if ($id_ruangan) {
                $query = "UPDATE ruangan SET nama_ruangan='$nama_ruangan', kapasitas='$kapasitas' WHERE id_ruangan=$id_ruangan";
            } else {
                $query = "INSERT INTO ruangan (nama_ruangan, kapasitas) VALUES ('$nama_ruangan', '$kapasitas')";
            }

            $conn->query($query);
            header("Location: ruangan.php");
        }

        $editData = null;
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM ruangan WHERE id_ruangan = $id");
            $editData = $result->fetch_assoc();
        }
        ?>

        <input type="hidden" name="id_ruangan" value="<?= $editData['id_ruangan'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Nama Ruangan</label>
            <input type="text" class="form-control" name="nama_ruangan" value="<?= $editData['nama_ruangan'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <input type="number" class="form-control" name="kapasitas" value="<?= $editData['kapasitas'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="ruangan.php" class="btn btn-secondary">Batal</a>
    </form>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Ruangan</th>
            <th>Kapasitas</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM ruangan";
        $result = $conn->query($query);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_ruangan']}</td>
                <td>{$row['kapasitas']}</td>
                <td>
                    <a href='ruangan.php?edit={$row['id_ruangan']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='ruangan.php?delete={$row['id_ruangan']}' class='btn btn-danger btn-sm'>Hapus</a>
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
