<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$product = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '" . $_GET['id'] . "' ");
$p = mysqli_fetch_object($product);
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
                        Add Product
                    </h3>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col my-3 h-auto">
                    <div class="p-3 d-flex flex-column align-items-start bg-primary rounded-4">

                        <form action="" method="POST" enctype="multipart/form-data">
                            <select class="input-control" name="category" required>
                                <option value="">Select Category</option>
                                <?php
                                $cat = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id ASC");
                                while ($r = mysqli_fetch_array($cat)) {
                                ?>
                                    <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : ''; ?>><?php echo $r['category_name'] ?></option>
                                <?php } ?>
                            </select>

                            <input type="text" name="name" class="input-control" placeholder="Product Name" value="<?php echo $p->product_name ?>" required>
                            <input type="text" name="price" class="input-control" placeholder="Price" value="<?php echo $p->product_price ?>" required>

                            <textarea class="input-control" name="description" placeholder="Description"><?php echo $p->product_desc ?></textarea>
                            <img src="img/<?php echo $p->product_image ?>" width="100px">
                            <input type="hidden" name="image" value="<?php echo $p->product_image ?>">
                            <input type="file" name="img-product" class="input-control">
                            <input type="submit" name="submit" value="Add" class="btn btn-success px-5">
                        </form>
                        <?php
                        if (isset($_POST['submit'])) {

                            $cat   = mysqli_real_escape_string($conn, $_POST['category']);
                            $name       = mysqli_real_escape_string($conn, $_POST['name']);
                            $price      = mysqli_real_escape_string($conn, $_POST['price']);
                            $desc  = mysqli_real_escape_string($conn, $_POST['description']);

                            $image  = $_POST['image'];

                            $filename   = $_FILES['img-product']['name'];
                            $tmp_name   = $_FILES['img-product']['tmp_name'];

                            $type1 = explode('.', $filename);
                            $type2 = $type1[1];

                            $newname = 'produk ' . $name . time() . '.' . $type2;

                            $acc = array('jpg', 'jpeg', 'png', 'svg');

                            if ($filename != '') {
                                $type1 = explode('.', $filename);
                                $type2 = $type1[1];

                                $newname = 'produk' . time() . '.' . $type2;

                                $acc = array('jpg', 'jpeg', 'png', 'svg');

                                // validasi format file
                                if (!in_array($type2, $acc)) {
                                    echo '<script>alert("Format file tidak diizinkan")</script>';
                                } else {
                                    unlink('./img/' . $image);
                                    move_uploaded_file($tmp_name, './img/' . $newname);
                                    $newimage = $newname;
                                }
                            } else {
                                $newimage = $image;
                            }

                            $update = mysqli_query($conn, "UPDATE tb_product SET
                                                        category_id = '" . $cat . "', 
                                                        product_name = '" . $name . "',
                                                        product_price = '" . $price . "',
                                                        product_desc = '" . $desc . "',
                                                        product_image = '" . $newimage . "'
                                                        WHERE product_id = '" . $p->product_id . "' ");

                            if ($update) {
                                echo '<script>alert=("Ubah data berhasil")</script>';
                                echo '<script>window.location="product.php"</script>';
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