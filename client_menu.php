<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'db_lunch';

$conn = mysqli_connect($hostname, $username, $password, $dbname) or die('Gagal terhubung ke database');
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
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!-- CSS -->

  <!-- SCRIPT -->
  <script>
    $(function() {
      $(".navbarPlaceholder").load("./components/navbar.html");
    });
    $(function() {
      $(".footerTemplate").load("./components/footer.html");
    });

    $(document).ready(function() {
      $(".category__img").on({
        mouseenter: function() {
          $(this).css("background-color", "#ababab");
        },
        mouseleave: function() {
          $(this).css("background-color", "#fff");
        },
      });
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

  <!-- MENU START -->
  <div class="container-fluid">
    <div class="row row-cols-2 row-cols-lg-6 g-2 g-lg-1 py-2 col-lg-10 mx-lg-auto fw-bold d-flex justify-content-center align-content-center">
      <?php
      $category = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id ASC");
      if (mysqli_num_rows($category) > 0) {
        while ($cat = mysqli_fetch_array($category)) {
      ?>
          <h2 class="h3 pt-4 fw-bold row row-cols-2 row-cols-lg-6 g-2 g-lg-3 col-lg-10 mx-lg-auto">
            <?php echo $cat['category_name'] ?>
          </h2>
          <?php
          $menu = mysqli_query($conn, "SELECT * FROM tb_product WHERE category_id=" . $cat['category_id'] . " ORDER BY product_id ASC");
          if (mysqli_num_rows($menu) > 0) {
            while ($row = mysqli_fetch_array($menu)) {
          ?>
              <a data-aos="zoom-in" data-aos-duration="1000" href="javascript:void(0)" class="col text-end text-decoration-none link-dark mx-lg-4 add-to-cart" data-product-id="<?php echo $row['product_id'] ?>" data-product-name="<?php echo $row['product_name'] ?>" data-product-price="<?php echo $row['product_price'] ?>" data-product-image="<?php echo $row['product_image'] ?>">
                <div class="category__img shadow">
                  <img src="img/<?php echo $row['product_image'] ?>" alt="<?php echo $row['product_name'] ?>" loading="lazy" class="img-fluid" />
                </div>
                <div class="pt-1"><?php echo $row['product_name'] ?></div>
                <div class="fw-light"><?php echo number_format($row['product_price']) ?></div>
              </a>
          <?php
            }
          } else {
            echo "<p>Tidak Ada Produk</p>";
          }
          ?>
        <?php }
      } else { ?>
        <p>No Data</p>
      <?php } ?>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="footerTemplate"></div>
  <!-- FOOTER -->

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Function to add product to cart
      function addToCart(product) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if product already exists in the cart
        let existingProduct = cart.find(item => item.id === product.id);

        if (existingProduct) {
          // If product exists, increase quantity
          existingProduct.quantity += 1;
        } else {
          // If product doesn't exist, add to cart with initial quantity of 1
          product.quantity = 1;
          cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        window.location.href = 'client_cart.php';
      }

      // Get all the "Add to Cart" links
      const addToCartLinks = document.querySelectorAll('.add-to-cart');

      addToCartLinks.forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault(); // Prevent the default link behavior
          const product = {
            id: this.getAttribute('data-product-id'),
            name: this.getAttribute('data-product-name'),
            price: this.getAttribute('data-product-price'),
            image: this.getAttribute('data-product-image'),
            desc: this.getAttribute('data-product-description')
          };
          addToCart(product);
        });
      });
    });
  </script>
</body>

</html>