<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rumah Sakit</title>
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
    <h1>Selamat Datang di Sistem Manajemen Rumah Sakit</h1>
    <p>Pilih salah satu menu di atas untuk mengelola data rumah sakit.</p>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
