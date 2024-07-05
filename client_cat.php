<?php
session_start();
include 'koneksi.php';

$category_id = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

// Fetch the category name for display
$category_query = "SELECT category_name FROM tb_category WHERE category_id = $category_id";
$category_result = mysqli_query($conn, $category_query);
$category_name = mysqli_fetch_assoc($category_result)['category_name'] ?? '';

// Fetch products based on the category ID
$product_query = "SELECT * FROM tb_product WHERE category_id = $category_id";
$product_result = mysqli_query($conn, $product_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lunch.</title>
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
  <!-- BOOTSTRAP -->
  <!-- JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- JQUERY -->
  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- FONT -->
  <!-- CSS -->
  <link rel="stylesheet" href="css/client_style.css" />
  <!-- CSS -->

  <!-- SCRIPT -->
  <script>
    $(function() {
      $(".navbarPlaceholder").load("./components/navbar.html");
    });
    $(function() {
      $(".footerTemplate").load("./components/footer.html");
    });
  </script>
  <!-- SCRIPT -->
</head>

<body>
  <div class="navbarPlaceholder"></div>

  <!-- NAVBAR CAT -->
  <div class="px-md-5 bg-light">
    <header class="d-flex flex-wrap align-items-center justify-content-center py-lg-1 py-md-4">
      <ul class="nav col-12 col-md-auto justify-content-center mb-md-0">
        <?php
        $category = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id ASC");
        if (mysqli_num_rows($category) > 0) {
          while ($cat = mysqli_fetch_array($category)) {
        ?>
            <li>
              <a href="client_cat.php?cat=<?php echo $cat['category_id']  ?>" class="nav-link px-2 px-lg-4 link-dark navbar_menu"><?php echo $cat['category_name'] ?></a>
            </li>
          <?php }
        } else { ?>
          <p>No Category</p>
        <?php } ?>
      </ul>
    </header>
  </div>
  <!-- NAVBAR CAT -->

  <!-- MENU DISPLAY -->
  <div class="container-fluid bg-light mt-2 shadow-sm w-100">
    <?php if (mysqli_num_rows($product_result) > 0) : ?>
      <?php while ($row = mysqli_fetch_assoc($product_result)) : ?>
        <div class="row mx-auto my-3">
          <div class="col-3 d-flex align-items-center justify-content-center">
            <img src="img/<?php echo $row['product_image']; ?>" class="img-fluid" alt="<?php echo $row['product_name']; ?>" />
          </div>
          <div class="col-9 py-3">
            <h3>
              <a href="product_detail.php?product_id=<?php echo $row['product_id']; ?>" class="text-decoration-none text-dark"><?php echo $row['product_name']; ?></a>
            </h3>
            <div class="row">
              <div class="col">
                <p id="paragraph" style="text-align: justify">
                  <?php echo $row['product_desc']; ?>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col d-flex justify-content-end">
                <button class="btn btn-warning rounded-5 px-4 add-to-cart" data-product-id="<?php echo $row['product_id']; ?>" data-product-name="<?php echo $row['product_name']; ?>" data-product-price="<?php echo $row['product_price']; ?>" data-product-image="<?php echo $row['product_image']; ?>">

                  Buy Now
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <p>No products found in this category.</p>
    <?php endif; ?>
  </div>
  <!-- MENU DISPLAY -->

  <!-- FOOTER -->
  <div id="footer" class="container-fluid pt-3 mt-5">
    <div class="row">
      <div class="col text-center h1 fw-bold">Lunch.</div>
    </div>
    <div class="row">
      <div class="col text-center fs-6 fw-semibold">Contact Us</div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 text-center py-3 justify-content-sm-between">
      <div class="col pb-4">
        <i class="bi bi-telephone me-2"></i>+6285235675120
      </div>
      <div class="col pb-4">
        <i class="bi bi-envelope me-2"></i>dewacahaya30@gmail.com
      </div>
      <div class="col pb-4">
        <i class="bi bi-instagram me-2"></i>dewacahaya._
      </div>
      <div class="col pb-4">
        <i class="bi bi-geo-alt me-2"></i>Tabanan, Bali
      </div>
    </div>
  </div>
  <!-- FOOTER -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // menambahkan produk ke cart
      function addToCart(product) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // mengecek produk apakah sudah ada di cart
        let existingProduct = cart.find(item => item.id === product.id);

        if (existingProduct) {
          // kalo produk ada, tambah jumlah
          existingProduct.quantity += 1;
        } else {
          // kalo ngga ada, tambahkan produk sebanyak 1
          product.quantity = 1;
          cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        window.location.href = 'client_cart.php';
      }

      // mengambil data tombol "Buy Now"
      const addToCartButtons = document.querySelectorAll('.add-to-cart');

      addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          const product = {
            id: this.getAttribute('data-product-id'),
            name: this.getAttribute('data-product-name'),
            price: this.getAttribute('data-product-price'),
            image: this.getAttribute('data-product-image')

          };
          addToCart(product);
        });
      });
    });
  </script>
</body>

</html>