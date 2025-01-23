<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Tambah Pesanan - Didin Laundry</title>
</head>
<body>

<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

include '../koneksi.php';

// Ambil data pelanggan berdasarkan ID yang diterima dari halaman pelanggan.php
if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    $query_info_pelanggan = "SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
    $result_info_pelanggan = mysqli_query($koneksi, $query_info_pelanggan);

    // Jika data pelanggan ditemukan, ambil informasi
    if ($result_info_pelanggan && mysqli_num_rows($result_info_pelanggan) > 0) {
        $data_info_pelanggan = mysqli_fetch_assoc($result_info_pelanggan);
        $nama_pelanggan = $data_info_pelanggan['nama_pelanggan'];
        $alamat_pelanggan = $data_info_pelanggan['alamat_pelanggan'];
        $telepon_pelanggan = $data_info_pelanggan['telepon_pelanggan'];
    } else {
        // Jika data pelanggan tidak ditemukan, kembali ke halaman pelanggan.php
        header('location: pelanggan.php');
    }
} else {
    // Jika tidak ada ID pelanggan, kembali ke halaman pelanggan.php
    header('location: pelanggan.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_layanan = $_POST['layanan'];
    $jumlah_kilogram = $_POST['jumlah_kilogram'];
    $jumlahPcs = $_POST['catatan_khusus'];
    $tanggal_ambil = $_POST['tanggal_ambil'];

    // Query untuk mengambil harga layanan
    $query_harga_layanan = "SELECT harga FROM harga_layanan WHERE id_layanan = $id_layanan";
    $result_harga_layanan = mysqli_query($koneksi, $query_harga_layanan);
    $data_harga_layanan = mysqli_fetch_assoc($result_harga_layanan);
    $harga_layanan = $data_harga_layanan['harga'];

    // Hitung total harga
    $total_harga = $harga_layanan * $jumlah_kilogram;

    // Simpan pesanan ke database
    $query_simpan_pesanan = "INSERT INTO transaksi (id_pelanggan, id_layanan, jumlah_kilogram, total_harga, jumlah_pcs, tanggal_ambil, status)
                             VALUES ('$id_pelanggan', '$id_layanan', '$jumlah_kilogram', '$total_harga', '$jumlahPcs', '$tanggal_ambil', 'Belum Selesai')";
    mysqli_query($koneksi, $query_simpan_pesanan);

    // Redirect ke halaman pelanggan setelah menyimpan pesanan
    header('location: pelanggan.php');
}
?>

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
                <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
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

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Pesanan untuk <?php echo $nama_pelanggan; ?></h4>
        </div>
        <div class="panel-body">
            <p><strong>Nama Pelanggan:</strong> <?php echo $nama_pelanggan; ?></p>
            <p><strong>Alamat:</strong> <?php echo $alamat_pelanggan; ?></p>
            <p><strong>No. Telepon:</strong> <?php echo $telepon_pelanggan; ?></p>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="layanan">Jenis Layanan:</label>
                    <select class="form-control" id="layanan" name="layanan" required>
                        <?php
                        // Query untuk mengambil data layanan
                        $query_layanan = "SELECT * FROM harga_layanan";
                        $result_layanan = mysqli_query($koneksi, $query_layanan);

                        while ($data_layanan = mysqli_fetch_assoc($result_layanan)) {
                            echo "<option value='" . $data_layanan['id_layanan'] . "'>" . $data_layanan['nama_layanan'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_kilogram">Jumlah Kilogram:</label>
                    <input type="number" class="form-control" id="jumlah_kilogram" name="jumlah_kilogram" required>
                </div>
                <div class="form-group">
                    <label for="catatan_khusus">Jumlah Pcs:</label>
                    <input type="number" class="form-control" id="catatan_khusus" name="catatan_khusus" rows="3"></input>
                </div>
                <div class="form-group">
                    <label for="tanggal_ambil">Tanggal Ambil:</label>
                    <input type="date" class="form-control" id="tanggal_ambil" name="tanggal_ambil" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Tambah Pesanan</button>
                <a href="pelanggan.php" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
