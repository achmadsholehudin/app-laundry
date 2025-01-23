<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Pelanggan - Didin Laundry</title>
</head>
<body>

<?php
session_start();
if ($_SESSION['status'] != "login") {
    header('location: ../index.php?pesan=belum_login');
}

// Koneksi ke database
include '../koneksi.php';

// Fungsi untuk membuat format rupiah pada angka
function formatRupiah($angka){
    $rupiah = "Rp " . number_format($angka,2,',','.');
    return $rupiah;
}

// Cek apakah tombol cari sudah diklik
if(isset($_GET['cari'])){
    // Ambil kata kunci pencarian
    $cari = $_GET['cari'];

    // Query untuk mencari pelanggan berdasarkan nama atau alamat
    $query_cari_pelanggan = "SELECT * FROM pelanggan WHERE nama_pelanggan LIKE '%$cari%' OR alamat_pelanggan LIKE '%$cari%' ORDER BY id_pelanggan ASC";
    $result_cari_pelanggan = mysqli_query($koneksi, $query_cari_pelanggan);
} else {
    // Query ambil data pelanggan
    $query_pelanggan = "SELECT * FROM pelanggan ORDER BY id_pelanggan ASC";
    $result_pelanggan = mysqli_query($koneksi, $query_pelanggan);
}

// Tangani penghapusan pelanggan
if (isset($_GET['hapus_pelanggan'])) {
    $id_pelanggan_hapus = $_GET['hapus_pelanggan'];
    $query_hapus_pelanggan = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan_hapus";
    mysqli_query($koneksi, $query_hapus_pelanggan);
    // Redirect setelah menghapus pelanggan
    header("Location: pelanggan.php");
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
            <div class="row">
                <div class="col-md-10">
                    <h4>Pelanggan</h4>
                </div>
            
            </div>
        </div>
        <div class="panel-body">
        <div class="table-responsive">

            <!-- Tambahkan tabel untuk menampilkan daftar pelanggan -->
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                        <!-- Tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($result_cari_pelanggan)){
                        // Gunakan hasil pencarian jika tombol cari diklik
                        $result_pelanggan = $result_cari_pelanggan;
                    }

                    $nomor = 1;
                    while ($data_pelanggan = mysqli_fetch_assoc($result_pelanggan)) : ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td><?php echo $data_pelanggan['nama_pelanggan']; ?></td>
                            <td><?php echo isset($data_pelanggan['alamat_pelanggan']) ? $data_pelanggan['alamat_pelanggan'] : 'Alamat tidak tersedia'; ?></td>
                            <td><?php echo isset($data_pelanggan['telepon_pelanggan']) ? $data_pelanggan['telepon_pelanggan'] : 'Telepon tidak tersedia'; ?></td>
                            <td>
                                <!-- Tambahkan tombol edit dengan mengirimkan ID pelanggan -->
                                <a href="edit_pelanggan.php?id_pelanggan=<?php echo $data_pelanggan['id_pelanggan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Tambahkan tombol tambah pesanan dengan mengirimkan ID pelanggan -->
                                <a href="tambah_pesanan.php?id_pelanggan=<?php echo $data_pelanggan['id_pelanggan']; ?>" class="btn btn-primary btn-sm">Tambah Pesanan</a>
                                <!-- Tambahkan tombol hapus dengan mengirimkan ID pelanggan -->
                                <a href="?hapus_pelanggan=<?php echo $data_pelanggan['id_pelanggan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus pelanggan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
                    </div>
    </div>
</div>

<script>
    new DataTable('#example');
</script>

</body>
</html>
