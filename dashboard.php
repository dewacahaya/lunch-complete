<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$report = "SELECT * FROM detail_penjualan";
$report_stat = mysqli_query($conn, $report);

$sales = [];
if (mysqli_num_rows($report_stat) > 0) {
    while ($row = mysqli_fetch_assoc($report_stat)) {
        if (isset($sales[$row['product_id']])) {
            $sales[$row['product_id']]['quantity'] += $row['quantity'];
            $sales[$row['product_id']]['total_price'] += $row['product_price'] * $row['quantity'];
        } else {
            $sales[$row['product_id']] = [
                'product_name' => $row['product_name'],
                'quantity' => $row['quantity'],
                'total_price' => $row['product_price'] * $row['quantity']
            ];
        }
    }
}
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
                <div class="col fw-bolder fs-2 d-flex align-items-center py-3 ps-3">
                    <h3>
                        Selamat Datang di Dashboard, <?php echo $_SESSION['admin_global']->name ?>
                    </h3>
                </div>
            </div>
            <div class="row row-col-3 mx-auto">
                <div class="col h-75">
                    <div class="h-50 p-3 d-flex flex-row align-items-center bg-primary rounded-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="white" class="bi bi-person-circle ms-3" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        <?php
                        $admin = "SELECT COUNT(*) as count FROM tb_admin";
                        $result = mysqli_query($conn, $admin);
                        $data = mysqli_fetch_assoc($result);
                        $jml_admin = $data['count'];
                        ?>
                        <span class="ms-5 text-white fs-3"><?php echo $jml_admin ?> Admin</span>
                    </div>
                </div>
                <div class="col h-75">
                    <div class="h-50 p-3 d-flex flex-row align-items-center bg-info rounded-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="white" class="bi bi-tag ms-3" viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0" />
                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z" />
                        </svg>
                        <?php
                        $cats = "SELECT COUNT(*) as count FROM tb_category";
                        $result = mysqli_query($conn, $cats);
                        $data = mysqli_fetch_assoc($result);
                        $jml_cats = $data['count'];
                        ?>
                        <span class="ms-5 text-white fs-5"><?php echo $jml_cats ?> Categories</span>
                    </div>
                </div>
                <div class="col h-75">
                    <div class="h-50 p-3 d-flex flex-row align-items-center bg-success rounded-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="white" class="bi bi-cup-straw ms-3" viewBox="0 0 16 16">
                            <path d="M13.902.334a.5.5 0 0 1-.28.65l-2.254.902-.4 1.927c.376.095.715.215.972.367.228.135.56.396.56.82q0 .069-.011.132l-.962 9.068a1.28 1.28 0 0 1-.524.93c-.488.34-1.494.87-3.01.87s-2.522-.53-3.01-.87a1.28 1.28 0 0 1-.524-.93L3.51 5.132A1 1 0 0 1 3.5 5c0-.424.332-.685.56-.82.262-.154.607-.276.99-.372C5.824 3.614 6.867 3.5 8 3.5c.712 0 1.389.045 1.985.127l.464-2.215a.5.5 0 0 1 .303-.356l2.5-1a.5.5 0 0 1 .65.278M9.768 4.607A14 14 0 0 0 8 4.5c-1.076 0-2.033.11-2.707.278A3.3 3.3 0 0 0 4.645 5c.146.073.362.15.648.222C5.967 5.39 6.924 5.5 8 5.5c.571 0 1.109-.03 1.588-.085zm.292 1.756C9.445 6.45 8.742 6.5 8 6.5c-1.133 0-2.176-.114-2.95-.308a6 6 0 0 1-.435-.127l.838 8.03c.013.121.06.186.102.215.357.249 1.168.69 2.438.69s2.081-.441 2.438-.69c.042-.029.09-.094.102-.215l.852-8.03a6 6 0 0 1-.435.127 9 9 0 0 1-.89.17zM4.467 4.884s.003.002.005.006zm7.066 0-.005.006zM11.354 5a3 3 0 0 0-.604-.21l-.099.445.055-.013c.286-.072.502-.149.648-.222" />
                        </svg>
                        <?php
                        $menu = "SELECT COUNT(*) as count FROM tb_product";
                        $result = mysqli_query($conn, $menu);
                        $data = mysqli_fetch_assoc($result);
                        $jml_pro = $data['count'];
                        ?>
                        <span class="ms-5 text-white fs-3"><?php echo $jml_pro ?> Menus</span>
                    </div>
                </div>

            </div>

            <div class="row mx-auto">
                <div class="col my-3 h-auto">
                    <div class="p-3 d-flex flex-row align-items-center bg-primary rounded-4">
                        <table border="1" class="table table-success table-striped text-center">
                            <thead>
                                <tr>
                                    <td>NO</td>
                                    <td>Nama Produk</td>
                                    <td>Total Pemasukan</td>
                                    <td>Total Terjual</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sales)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sales as $product_id => $details) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($details['product_name']); ?></td>
                                            <td><?php echo number_format($details['total_price'], 2); ?></td>
                                            <td><?php echo $details['quantity']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</body>

</html>