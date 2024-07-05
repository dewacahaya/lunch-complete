<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$cat = mysqli_query($conn, "SELECT * FROM tb_category WHERE category_id= '" . $_GET['id'] . "' ");
if (mysqli_num_rows($cat) == 0) {
    echo '<script>window.location="category.php"</script>';
}
$k = mysqli_fetch_object($cat);
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
                        Add Category
                    </h3>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col my-3 h-auto">
                    <div class="p-3 d-flex flex-column align-items-start bg-primary rounded-4">
                        <form action="" method="POST" class="w-100">
                            <input type="text" name="nama" placeholder="Category Name" class="input-control" value="<?php echo $k->category_name ?>" required>
                            <input type="submit" name="submit" value="Save" class="btn btn-success px-5">
                        </form>
                        <?php
                        if (isset($_POST['submit'])) {

                            $nama = ucwords($_POST['nama']);

                            $update = mysqli_query($conn, "UPDATE tb_category SET 
                                                    category_name = '" . $nama . "'
                                                    WHERE category_id = '" . $k->category_id . "' ");

                            if ($update) {
                                echo '<script>alert("Edit Data Berhasil")</script>';
                                echo '<script>window.location="category.php"</script>';
                            } else {
                                echo 'gagal ' . mysqli_error($conn);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>