<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link href="img/logokedua.jpeg" rel="shortcut icon" type="image/">

    <title>Sistem Informasi Laundry</title>
</head>
<body style="background: #f0f0f0"><br><br><br>
    <center>
        <img src="img/didin-laundry.png" width="110px" height="110px" alt="">
        <!-- <h2>Sistem Informasi Laundry <br>
        Pemrograman Berbasis Web</h2> -->
        <h2>DIDIN LAUNDRY</h2>
    </center>
    <br><br><br>
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo "<div class='alert alert-danger'>Login gagal!</div>";
            } else if ($_GET['pesan'] == "logout") {
                echo "<div class='alert alert-info'>Logout berhasil!</div>";
            } else if ($_GET['pesan'] == "belum_login") {
                echo "<div class='alert alert-warning'>Anda belum login!</div>";
            }
        }
        ?>
        <form action="aksi.php" method="post">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Log In">
                    <input type="reset" class="btn btn-secondary" value="Reset">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
