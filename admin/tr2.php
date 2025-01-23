<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../img/logokedua.jpeg" rel="shortcut icon" type="image/">
    <title>Transaksi - Didin Laundry</title>
    <style>
        @media (min-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <?php
    session_start();
    if ($_SESSION['status'] != "login") {
        header('location: ../index.php?pesan=belum_login');
    }

    include '../koneksi.php';

    if (isset($_GET['ubah_status']) && isset($_GET['status'])) {
        $id_transaksi = $_GET['ubah_status'];
        $status = $_GET['status'];

        if ($status == 'Belum Selesai') {
            $query_ubah_status = "UPDATE transaksi SET status = 'Selesai' WHERE id_transaksi = $id_transaksi";
        } elseif ($status == 'Selesai') {
            $query_ubah_status = "UPDATE transaksi SET status = 'Belum Selesai' WHERE id_transaksi = $id_transaksi";
        }

        mysqli_query($koneksi, $query_ubah_status);
    }

    if (isset($_GET['hapus_transaksi'])) {
        $id_transaksi_hapus = $_GET['hapus_transaksi'];
        $query_hapus_transaksi = "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi_hapus";
        mysqli_query($koneksi, $query_hapus_transaksi);
    }

    // Query transaksi dengan kondisi pencarian
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query_transaksi = "SELECT * FROM transaksi 
                        WHERE id_pelanggan IN (SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan LIKE '%$search%')
                        OR jumlah_pcs LIKE '%$search%'";
    $result_transaksi = mysqli_query($koneksi, $query_transaksi);
    ?>

    <nav class="navbar navbar-inverse" style="border-radius: 0px">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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

    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Transaksi</h4>
                    </div>
                    <div class="col-sm-6">
                        <form class="form-inline pull-right" action="" method="get">
                            <div class="form-group">
                                <!-- <label for="search">Cari:</label> -->
                                <input type="text" class="form-control" id="search" name="search" placeholder="Nama Pelanggan">
                            </div>
                            <button type="submit" class="btn btn-default">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Jenis Layanan</th>
                                <th>Tanggal Ambil</th>
                                <th>Jumlah pcs</th>
                                <th>Jumlah Kilogram</th>
                                <th>Total Harga</th>
                                <th>Admin/Kasir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($data_transaksi = mysqli_fetch_assoc($result_transaksi)) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php
                                        $id_pelanggan = $data_transaksi['id_pelanggan'];
                                        $query_nama_pelanggan = "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
                                        $result_nama_pelanggan = mysqli_query($koneksi, $query_nama_pelanggan);
                                        $data_nama_pelanggan = mysqli_fetch_assoc($result_nama_pelanggan);
                                        echo isset($data_nama_pelanggan['nama_pelanggan']) ? $data_nama_pelanggan['nama_pelanggan'] : '';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $id_layanan = $data_transaksi['id_layanan'];
                                        $query_nama_layanan = "SELECT nama_layanan FROM harga_layanan WHERE id_layanan = $id_layanan";
                                        $result_nama_layanan = mysqli_query($koneksi, $query_nama_layanan);
                                        $data_nama_layanan = mysqli_fetch_assoc($result_nama_layanan);
                                        echo isset($data_nama_layanan['nama_layanan']) ? $data_nama_layanan['nama_layanan'] : '';
                                        ?>
                                    </td>
                                    <td><?php echo $data_transaksi['tanggal_ambil']; ?></td>
                                    <td><?php echo $data_transaksi['jumlah_pcs']; ?></td>
                                    <td><?php echo $data_transaksi['jumlah_kilogram']; ?></td>
                                    <td><?php echo $data_transaksi['total_harga']; ?></td>
                                    <td><?php echo $_SESSION['username']; ?></td>
                                    <td><?php echo $data_transaksi['status']; ?></td>
                                    <td>
                                        <?php if ($data_transaksi['status'] == 'Belum Selesai') : ?>
                                            <a href="?ubah_status=<?php echo $data_transaksi['id_transaksi']; ?>&status=<?php echo $data_transaksi['status']; ?>" class="btn btn-success btn-sm">Ubah Status</a>
                                        <?php elseif ($data_transaksi['status'] == 'Selesai') : ?>
                                            <a href="?ubah_status=<?php echo $data_transaksi['id_transaksi']; ?>&status=<?php echo $data_transaksi['status']; ?>" class="btn btn-warning btn-sm">Ubah Status</a>
                                        <?php endif; ?>

                                        <a href="edit_transaksi.php?id=<?php echo $data_transaksi['id_transaksi']; ?>" class="btn btn-primary btn-sm">Edit</a>

                                        <a href="?hapus_transaksi=<?php echo $data_transaksi['id_transaksi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus transaksi ini?')">Hapus</a>

                                        <a href="#" class="btn btn-info btn-sm" onclick="printTransaksi('<?php echo $data_transaksi['id_transaksi']; ?>')">Print</a>
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
        function printTransaksi(idTransaksi) {
            // Implementasi fungsi print transaksi di sini
            alert('Fungsi print transaksi belum diimplementasikan. ID Transaksi: ' + idTransaksi);
        }
    </script>

</body>

</html>
