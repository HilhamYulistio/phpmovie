<?php
$film_id = isset($_GET['film']) ? (int) $_GET['film'] : 0;

$judul_film = '';

if ($film_id === 1) {
    $judul_film = 'Spider-Man: Homecoming';
} elseif ($film_id === 2) {
    $judul_film = 'Spider-Man: Far From Home';
} elseif ($film_id === 3) {
    $judul_film = 'Spider-Man: No Way Home';
} else {
    $judul_film = 'Film tidak ditemukan';
}

$totalAkhirText = '';
$totalHargaAkhir = 0;
$harga = 0;

function hitungTotalHarga($jenisTiket, $jumlahTiket, $hariPemesanan)
{
    global $totalAkhirText, $totalHargaAkhir, $harga;

    $hargaDewasa = 50000;
    $hargaAnak = 30000;
    $extra = 10000;

    if ($jenisTiket == "dewasa") {
        $harga = $hargaDewasa;
    } elseif ($jenisTiket == "anak") {
        $harga = $hargaAnak;
    } else {
        $totalAkhirText = "Jenis tiket tidak valid.";
        return;
    }

    $totalHarga = $harga * $jumlahTiket;

    if ($hariPemesanan == "Sabtu" || $hariPemesanan == "Minggu") {
        $totalHarga += $extra * $jumlahTiket;
        $totalAkhirText = "Weekend mendapat penambahan sebesar 10.0000/ticket <br>";

    }

    if ($totalHarga > 150000) {
        $totalHargaAkhir = $totalHarga * 0.9;
        $totalAkhirText .= "Total harga sebelum diskon: Rp " . number_format($totalHarga, 0, ',', '.') . "<br>";
        $totalAkhirText .= "Diskon 10% telah diterapkan.<br>";
        $totalAkhirText .= "Total harga setelah diskon: Rp " . number_format($totalHargaAkhir, 0, ',', '.');
    } else {
        $totalHargaAkhir = $totalHarga;
        $totalAkhirText .= "Total harga: Rp " . number_format($totalHarga, 0, ',', '.');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenisTiket = $_POST['jenisTiket'];
    $jumlahTiket = (int) $_POST['jumlahTiket'];
    $hariPemesanan = $_POST['hariPemesanan'];

    hitungTotalHarga($jenisTiket, $jumlahTiket, $hariPemesanan);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <style>
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-film"></i> HammMovie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#movies"><i class="fas fa-list"></i> Daftar Film</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact"><i class="fas fa-info"></i> Hubungi Kami</a>
                    </li>
                </ul> -->
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Pemesanan Tiket</h2>

            <!-- Form Pemesanan -->
            <form id="ticketForm" method="post">
                <div class="mb-3">
                    <label for="nameMovie" class="form-label">Nama Film</label>
                    <input type="text" class="form-control text-center" id="nameMovie" value="<?= $judul_film ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="jenisTiket" class="form-label">Jenis Tiket</label>
                    <select class="form-select text-center" id="jenisTiket" name="jenisTiket" required>
                        <option selected disabled>Pilih Jenis Tiket</option>
                        <option value="dewasa">Dewasa - Rp 50.000</option>
                        <option value="anak">Anak-anak - Rp 30.000</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlahTiket" class="form-label">Jumlah Tiket</label>
                    <input type="number" class="form-control text-center" id="jumlahTiket" name="jumlahTiket"
                        placeholder="Masukkan jumlah tiket" required>
                </div>

                <div class="mb-3">
                    <label for="hariPemesanan" class="form-label">Hari Pemesanan</label>
                    <select class="form-select text-center" id="hariPemesanan" name="hariPemesanan" required>
                        <option selected disabled>Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Hitung Total Harga</button>
                <a href="./index.html" class="btn btn-secondary">Kembali</a>
            </form>

            <!-- Modal yang menampilkan hasil perhitungan -->
            <div class="modal fade show <?= ($_SERVER["REQUEST_METHOD"] == "POST") ? 'd-block' : '' ?>" id="resultModal"
                tabindex="-1" role="dialog"
                style="<?= ($_SERVER["REQUEST_METHOD"] == "POST") ? 'display: block;' : 'display: none;' ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Rincian Pembayaran Tiket</h5>
                        </div>
                        <div class="modal-body">
                            <p><strong>Nama Film:</strong> <?= $judul_film ?></p>
                            <p><strong>Jenis Tiket:</strong> <?= $jenisTiket ?></p>
                            <p><strong>Harga Tiket:</strong> <?= $harga ?></p>
                            <p><strong>Jumlah Tiket:</strong> <?= $jumlahTiket ?></p>
                            <p><strong>Hari Pemesanan:</strong> <?= $hariPemesanan ?></p>
                            <p><strong>Rincian Harga:</strong><br><?= $totalAkhirText ?></p>
                        </div>
                        <div class="modal-footer">
                            <a href="./index.html" class="btn btn-secondary">Tutup</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>