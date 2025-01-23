<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Dashboard - Didin Laundry</title>
</head>
<body>

<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

// Koneksi ke database
include '../koneksi.php';

// Proses Input Pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaPelanggan = $_POST['nama_pelanggan'];
    $alamatPelanggan = $_POST['alamat_pelanggan'];
    $teleponPelanggan = $_POST['telepon_pelanggan'];
    $jenisLayanan = $_POST['jenis_layanan'];
    $jumlahKilogram = $_POST['jumlah_kilogram'];
    $tanggalAmbil = $_POST['tanggal_ambil'];
    $jumlahPcs = $_POST['jumlah_pcs'];

    // Cek apakah pelanggan sudah ada atau belum
    $cekPelanggan = "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = '$namaPelanggan'";
    $resultPelanggan = mysqli_query($koneksi, $cekPelanggan);

    // Jika pelanggan belum ada, tambahkan pelanggan baru
    if (mysqli_num_rows($resultPelanggan) == 0) {
        $tambahPelanggan = "INSERT INTO pelanggan (nama_pelanggan, alamat_pelanggan, telepon_pelanggan) VALUES ('$namaPelanggan', '$alamatPelanggan', '$teleponPelanggan')";
        mysqli_query($koneksi, $tambahPelanggan);

        // Ambil id_pelanggan yang baru ditambahkan
        $idPelangganBaru = mysqli_insert_id($koneksi);

        // Ambil data harga layanan berdasarkan jenis layanan
        $queryHargaLayanan = "SELECT * FROM harga_layanan WHERE id_layanan = '$jenisLayanan'";
        $resultHargaLayanan = mysqli_query($koneksi, $queryHargaLayanan);
        $dataHargaLayanan = mysqli_fetch_assoc($resultHargaLayanan);

        // Hitung total harga
        $totalHarga = $dataHargaLayanan['harga'] * $jumlahKilogram;

        // Tambahkan transaksi menggunakan id_pelanggan yang baru
        $query = "INSERT INTO transaksi (id_pelanggan, id_layanan, jumlah_kilogram, tanggal_ambil, jumlah_pcs, harga, total_harga) 
                  VALUES ('$idPelangganBaru', '$jenisLayanan', '$jumlahKilogram', '$tanggalAmbil', '$jumlahPcs', '{$dataHargaLayanan['harga']}', '$totalHarga')";
        mysqli_query($koneksi, $query);
    } else {
        // Jika pelanggan sudah ada, ambil id_pelanggan yang sudah ada
        $dataPelanggan = mysqli_fetch_assoc($resultPelanggan);
        $idPelanggan = $dataPelanggan['id_pelanggan'];

        // Ambil data harga layanan berdasarkan jenis layanan
        $queryHargaLayanan = "SELECT * FROM harga_layanan WHERE id_layanan = '$jenisLayanan'";
        $resultHargaLayanan = mysqli_query($koneksi, $queryHargaLayanan);
        $dataHargaLayanan = mysqli_fetch_assoc($resultHargaLayanan);

        // Hitung total harga
        $totalHarga = $dataHargaLayanan['harga'] * $jumlahKilogram;

        // Tambahkan transaksi menggunakan id_pelanggan yang sudah ada
        $query = "INSERT INTO transaksi (id_pelanggan, id_layanan, jumlah_kilogram, tanggal_ambil, jumlah_pcs, harga, total_harga) 
                  VALUES ('$idPelanggan', '$jenisLayanan', '$jumlahKilogram', '$tanggalAmbil', '$jumlahPcs', '{$dataHargaLayanan['harga']}', '$totalHarga')";
        mysqli_query($koneksi, $query);
    }
}
?>

<!-- Menu navigasi -->
<nav class="navbar navbar-inverse" style="border-radius: 0px">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">DIDIN LAUNDRY</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                <li><a href="pelanggan.php"><i class="glyphicon glyphicon-user"></i> Pelanggan</a></li>
                <li><a href="transaksi.php"><i class="glyphicon glyphicon-random"></i> Transaksi</a></li>
                <li><a href="laporan.php"><i class="glyphicon glyphicon-list-alt"></i> Laporan</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-wrench"></i> Pengaturan <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="harga.php"><i class="glyphicon glyphicon-usd"></i> Pengaturan Harga</a></li>
                        <li><a href="ganti_password.php"><i class="glyphicon glyphicon-lock"></i> Ganti Password</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-text">Halo, <b><?php echo $_SESSION['username']; ?></b></p>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Akhir menu navigasi -->

<div class="container">
    <!-- <div class="alert alert-info text-center">
        <h4 style="margin-bottom: 0px"><b>Selamat datang!</b> di sistem informasi laundry Pemrograman Web Dasar.</h4>
    </div> -->
    <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Input pesanan/pelanggan baru</h4>
        </div>
        <!-- <div class="panel-body">
            Sistem Informasi Laundry Pemrograman Web Dasar
        </div> --><br>

        <form action="" method="post">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan:</label>
                <input type="text" class="form-control" name="nama_pelanggan" required>
            </div>

            <div class="form-group">
                <label for="alamat_pelanggan">Alamat Pelanggan:</label>
                <input type="text" class="form-control" name="alamat_pelanggan" required>
            </div>

            <div class="form-group">
                <label for="telepon_pelanggan">Nomor Telepon Pelanggan:</label>
                <input type="tel" class="form-control" name="telepon_pelanggan" required>
            </div>

            <div class="form-group">
                <label for="jenis_layanan">Jenis Layanan:</label>
                <select class="form-control" name="jenis_layanan" id="jenis_layanan" required>
                    <?php
                    // Ambil data jenis layanan dari database
                    $queryJenisLayanan = "SELECT * FROM harga_layanan";
                    $resultJenisLayanan = mysqli_query($koneksi, $queryJenisLayanan);

                    while ($dataJenisLayanan = mysqli_fetch_assoc($resultJenisLayanan)) {
                        echo "<option value='{$dataJenisLayanan['id_layanan']}'>{$dataJenisLayanan['nama_layanan']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah_pcs">Jumlah Pcs:</label>
                <input type="number" class="form-control" name="jumlah_pcs">
            </div>

            <div class="form-group">
                <label for="jumlah_kilogram">Jumlah Kilogram:</label>
                <input type="number" class="form-control" name="jumlah_kilogram" min="1" required>
            </div>

            <div class="form-group">
                <label for="tanggal_ambil">Tanggal Ambil:</label>
                <input type="date" class="form-control" name="tanggal_ambil" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
        </form>
    </div>
                </div>
</div>

</body>
</html>
