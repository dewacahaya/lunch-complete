<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE id_admin = '" . $_SESSION['id'] . "' ");
$d = mysqli_fetch_object($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunch. Dashboard</title>
    <link rel="icon" href="">
    <link rel="stylesheet" href="./css/style.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <!-- FONT -->
</head>

<body>
    <header>
        <div class="px-md-3">
            <a href="dashboard.php">Dashboard</a>
        </div>
    </header>

    <section class="d-flex row row-col-2 h-calc">
        <div class="bg-warning col-2 d-flex flex-column justify-content-between h-calc">
            <ul class="list-unstyled text-center flex-grow-1">
                <li class="my-5"><a href="dashboard.php" class="text-decoration-none text-white side_menu">Dashboard</a></li>
                <li class="my-5"><a href=" category.php" class="text-decoration-none text-white side_menu">Category</a></li>
                <li class="my-5"><a href=" product.php" class="text-decoration-none text-white side_menu">Product</a></li>
                <li class="my-5"><a href=" profile.php" class="text-decoration-none text-white side_menu">Profile</a></li>
            </ul>
            <ul class="list-unstyled text-center">
                <li class="my-5"><a href=" logout.php" class="text-decoration-none text-white side_menu">Logout</a></li>
            </ul>
        </div>
        <div class="col-10">
            <div class="row">
                <div class="col fw-bolder fs-2 d-flex align-items-center pt-3 ps-3">
                    <h3>
                        Profile
                    </h3>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col my-2 h-auto">
                    <div class="p-3 d-flex flex-row align-items-center bg-secondary rounded-4">
                        <form action="" method="POST" class="w-100">
                            <label for="nama" class="pb-2 text-white">Name</label>
                            <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->name ?>" required>
                            <label for="user" class="pb-2 text-white">Username</label>
                            <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username ?>" required>
                            <input type="submit" name="submit" value="Save" class="btn btn-success px-5">
                        </form>
                        <?php
                        if (isset($_POST['submit'])) {

                            $nama   = ucwords($_POST['nama']);
                            $user   = $_POST['user'];

                            $update = mysqli_query($conn, "UPDATE tb_admin SET
                                        name      = '" . $nama . "',
                                        username        = '" . $user . "'
                                        WHERE id_admin = '" . $d->id_admin . "' ");
                            if ($update) {
                                echo '<script>alert("Data Telah Tersimpan")</script>';
                                echo '<script>window.location="profile.php"</script>';
                            } else {
                                echo 'GAGAL ' . mysqli_error($conn);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col fw-bolder fs-2 d-flex align-items-center pt-3 ps-3">
                    <h3>
                        Update Password
                    </h3>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col my-2 h-auto">
                    <div class="p-3 d-flex flex-row align-items-center bg-secondary rounded-4">
                        <form action="" method="POST" class="w-100">
                            <input type="password" name="pass1" placeholder="New Password" class="input-control" required>
                            <input type="password" name="pass2" placeholder="Confirm Password" class="input-control" required>
                            <input type="submit" name="ubah_password" value="Update" class="btn btn-primary px-5 text-white">
                        </form>
                        <?php
                        if (isset($_POST['ubah_password'])) {

                            $pass1     = $_POST['pass1'];
                            $pass2     = $_POST['pass2'];

                            if ($pass2 != $pass1) {
                                echo '<script>alert("Password Atau Konfirmasi Password Baru Tidak Sesuai")</script>';
                            } else {

                                $u_pass = mysqli_query($conn, "UPDATE tb_admin SET
                                        password   = '" . $pass1 . "'
                                        WHERE id_admin = '" . $d->id_admin . "' ");
                                if ($u_pass) {
                                    echo '<script>alert("Data Telah Tersimpan")</script>';
                                    echo '<script>window.location="profile.php"</script>';
                                } else {
                                    echo 'GAGAL ' . mysqli_error($conn);
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

</body>

</html>