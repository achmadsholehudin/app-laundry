<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Edit Pelanggan - Didin Laundry</title>
</head>
<body>

<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

// Koneksi ke database
include '../koneksi.php';

// Ambil data pelanggan berdasarkan ID
$id_pelanggan = $_GET['id_pelanggan'];
$query_edit_pelanggan = "SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
$result_edit_pelanggan = mysqli_query($koneksi, $query_edit_pelanggan);
$data_edit_pelanggan = mysqli_fetch_assoc($result_edit_pelanggan);

// Proses update data pelanggan
if (isset($_POST['update_pelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];
    $telepon_pelanggan = $_POST['telepon_pelanggan'];

    $query_update_pelanggan = "UPDATE pelanggan SET nama_pelanggan = '$nama_pelanggan', alamat_pelanggan = '$alamat_pelanggan', telepon_pelanggan = '$telepon_pelanggan' WHERE id_pelanggan = $id_pelanggan";

    mysqli_query($koneksi, $query_update_pelanggan);

    header('location: pelanggan.php');
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
                <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                <li class="active"><a href="pelanggan.php"><i class="glyphicon glyphicon-user"></i> Pelanggan</a></li>
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

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Pelanggan</h4>
        </div>
        <div class="panel-body">
            <!-- Form edit pelanggan -->
            <form method="post" action="">
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan:</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $data_edit_pelanggan['nama_pelanggan']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat_pelanggan">Alamat Pelanggan:</label>
                    <textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" required><?php echo $data_edit_pelanggan['alamat_pelanggan']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="telepon_pelanggan">No. Telepon Pelanggan:</label>
                    <input type="text" class="form-control" id="telepon_pelanggan" name="telepon_pelanggan" value="<?php echo $data_edit_pelanggan['telepon_pelanggan']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="update_pelanggan">Update</button>
                <a href="pelanggan.php" class="btn btn-default">Kembali</a>
            </form>
            <!-- Akhir form edit pelanggan -->
        </div>
    </div>

</div>

</body>
</html>
