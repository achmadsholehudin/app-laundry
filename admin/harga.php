<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Pengaturan Harga Layanan - Didin Laundry</title>
</head>
<body>

<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

include '../koneksi.php';

// Fungsi untuk mengambil data layanan berdasarkan ID
function getLayananById($id) {
    global $koneksi;
    $query_get_layanan = "SELECT * FROM harga_layanan WHERE id_layanan = $id";
    $result_get_layanan = mysqli_query($koneksi, $query_get_layanan);
    return mysqli_fetch_assoc($result_get_layanan);
}

// Fungsi untuk menambah layanan dan harga
if (isset($_POST['submit'])) {
    $nama_layanan = $_POST['nama_layanan'];
    $harga = $_POST['harga'];

    if (empty($_POST['edit_id'])) {
        // Insert data baru
        $query_tambah_harga = "INSERT INTO harga_layanan (nama_layanan, harga) VALUES ('$nama_layanan', $harga)";
    } else {
        // Update data berdasarkan ID
        $edit_id = $_POST['edit_id'];
        $query_tambah_harga = "UPDATE harga_layanan SET nama_layanan = '$nama_layanan', harga = $harga WHERE id_layanan = $edit_id";
    }

    if (mysqli_query($koneksi, $query_tambah_harga)) {
        header('location: harga.php');
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Fungsi untuk menghapus layanan dan harga
if (isset($_GET['hapus_harga'])) {
    $id_harga = $_GET['hapus_harga'];
    $query_hapus_harga = "DELETE FROM harga_layanan WHERE id_layanan = $id_harga";

    if (mysqli_query($koneksi, $query_hapus_harga)) {
        header('location: harga.php');
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Ambil data layanan jika tombol Edit diklik
$data_edit = null;
if (isset($_GET['edit_harga'])) {
    $id_edit = $_GET['edit_harga'];
    $data_edit = getLayananById($id_edit);
}

// Query ambil data harga layanan
$query_harga_layanan = "SELECT * FROM harga_layanan";
$result_harga_layanan = mysqli_query($koneksi, $query_harga_layanan);
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
                <li class="active"><a href="harga.php"><i class="glyphicon glyphicon-usd"></i> Pengaturan Harga</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-wrench"></i> Pengaturan <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
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
            <h4>Pengaturan Harga Layanan</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="">
                <!-- Tambahkan input hidden untuk menyimpan ID layanan yang diedit -->
                <input type="hidden" name="edit_id" value="<?php echo isset($data_edit['id_layanan']) ? $data_edit['id_layanan'] : ''; ?>">

                <div class="form-group">
                    <label for="nama_layanan">Nama Layanan:</label>
                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="<?php echo isset($data_edit['nama_layanan']) ? $data_edit['nama_layanan'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo isset($data_edit['harga']) ? $data_edit['harga'] : ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit"><?php echo isset($data_edit) ? 'Update' : 'Tambah'; ?> Harga</button>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Daftar Harga Layanan</h4>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Layanan</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data_harga_layanan = mysqli_fetch_assoc($result_harga_layanan)) : ?>
                        <tr>
                            <td><?php echo $data_harga_layanan['id_layanan']; ?></td>
                            <td><?php echo $data_harga_layanan['nama_layanan']; ?></td>
                            <td><?php echo $data_harga_layanan['harga']; ?></td>
                            <td>
                                <a href="?edit_harga=<?php echo $data_harga_layanan['id_layanan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?hapus_harga=<?php echo $data_harga_layanan['id_layanan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus layanan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
