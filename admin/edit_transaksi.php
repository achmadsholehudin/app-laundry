<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

include '../koneksi.php';

// Ambil data transaksi berdasarkan ID
if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query_detail_transaksi = "SELECT transaksi.*, pelanggan.nama_pelanggan, harga_layanan.nama_layanan, admin.username
                               FROM transaksi
                               JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan
                               JOIN harga_layanan ON transaksi.id_layanan = harga_layanan.id_layanan
                            --    JOIN admin ON transaksi.username = admin.username
                               WHERE transaksi.id_transaksi = $id_transaksi";
    $result_detail_transaksi = mysqli_query($koneksi, $query_detail_transaksi);
    $data_detail_transaksi = mysqli_fetch_assoc($result_detail_transaksi);
    
    // Check jika data tidak ditemukan
    if (!$data_detail_transaksi) {
        header('location: transaksi.php');
        exit(); // Hentikan eksekusi script setelah mengarahkan ke halaman transaksi.php
    }
} else {
    // Redirect jika ID tidak tersedia
    header('location: transaksi.php');
    exit(); // Hentikan eksekusi script setelah mengarahkan ke halaman transaksi.php
}

// Fungsi untuk mengubah data transaksi
if (isset($_POST['submit'])) {
    $tanggal_ambil = $_POST['tanggal_ambil'];
    $jumlah_pcs = $_POST['jumlah_pcs'];

    $query_update_transaksi = "UPDATE transaksi 
                               SET tanggal_ambil = '$tanggal_ambil', jumlah_pcs = '$jumlah_pcs' 
                               WHERE id_transaksi = $id_transaksi";

    if (mysqli_query($koneksi, $query_update_transaksi)) {
        header('location: transaksi.php');
        exit(); // Hentikan eksekusi script setelah mengarahkan ke halaman transaksi.php
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Edit Transaksi - Didin Laundry</title>
</head>
<body>

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
                <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                <li><a href="pelanggan.php"><i class="glyphicon glyphicon-user"></i> Pelanggan</a></li>
                <li class="active"><a href="transaksi.php"><i class="glyphicon glyphicon-random"></i> Transaksi</a></li>
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Transaksi</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan:</label>
                    <input type="text" class="form-control" id="nama_pelanggan" value="<?php echo $data_detail_transaksi['nama_pelanggan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="admin_kasir">Admin/Kasir:</label>
                    <input type="text" class="form-control" id="admin_kasir" value="<?php echo $data_detail_transaksi['username']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="jenis_layanan">Jenis Layanan:</label>
                    <input type="text" class="form-control" id="jenis_layanan" value="<?php echo $data_detail_transaksi['nama_layanan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="tanggal_ambil">Tanggal Ambil:</label>
                    <input type="date" class="form-control" id="tanggal_ambil" name="tanggal_ambil" value="<?php echo $data_detail_transaksi['tanggal_ambil']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_pcs">Jumlah pcs:</label>
                    <input type="text" class="form-control" id="jumlah_pcs" name="jumlah_pcs" value="<?php echo $data_detail_transaksi['jumlah_pcs']; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
                <a href="transaksi.php" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
