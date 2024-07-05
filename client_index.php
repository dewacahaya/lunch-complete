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
  <link rel="stylesheet" href="./css/client_style.css" />
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
  </script>
  <!-- SCRIPT -->
</head>
<html>
<!-- NAVBAR -->
<div class="px-md-5 bg-warning">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-lg-4 py-md-4">
    <a href="client_index.php" class="fw-bolder fs-2 d-flex align-items-center col-md-3 mb-md-0 text-dark text-decoration-none">
      Lunch.
    </a>

    <ul class="nav col-12 col-md-auto justify-content-center mb-md-0">
      <li>
        <a href="client_menu.php" class="nav-link px-2 px-lg-4 link-dark navbar_menu">Menu</a>
      </li>
      <li>
        <a href="client_promo.html" class="nav-link px-2 px-lg-4 link-dark navbar_menu">Promo</a>
      </li>
      <li>
        <a href="client_about.html" class="nav-link px-2 px-lg-4 link-dark navbar_menu">About Us</a>
      </li>
    </ul>
  </header>
</div>
<!-- NAVBAR -->

<!-- BANNER -->
<div id="carouselExampleIndicators" data-aos="fade" data-aos-duration="2500" class="carousel slide mt-3">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/banner/banner.png" class="d-block w-100" alt="..." />
    </div>
    <div class="carousel-item">
      <img src="assets/banner/banner-1.png" class="d-block w-100" alt="..." />
    </div>
    <div class="carousel-item">
      <img src="assets/banner/banner-2.png" class="d-block w-100" alt="..." />
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- MENU -->
<div class="container-fluid">
  <div class="row row-cols-2 row-cols-lg-6 g-2 g-lg-3 py-4 col-lg-10 mx-lg-auto fw-bold d-flex justify-content-center align-content-center">
    <a href="./client_menu.php" class="col text-center text-decoration-none link-dark mx-lg-3">
      <div data-aos="zoom-in" data-aos-duration="2000" class="category__img">
        <img src="assets/images/pngwing 1.png" class="img-fluid" alt="Burger" loading="lazy" />
      </div>
      <div class="pt-1">Burger</div>
    </a>
    <a href="./client_menu.php" class="col text-center text-decoration-none link-dark mx-lg-3">
      <div class="category__img" data-aos="zoom-in" data-aos-duration="2000">
        <img src="assets/images/pngwing 2.png" class="img-fluid" alt="French Fries" loading="lazy" />
      </div>
      <div class="pt-1">French Fries</div>
    </a>
    <a href="./client_menu.php" class="col text-center text-decoration-none link-dark mx-lg-3">
      <div class="category__img" data-aos="zoom-in" data-aos-duration="2000">
        <img src="assets/images/pngwing 3.png" class="img-fluid" alt="Drinks" loading="lazy" />
      </div>
      <div class="pt-1">Drinks</div>
    </a>
    <a href="./client_menu.php" class="col text-center text-decoration-none link-dark mx-lg-3">
      <div class="category__img" data-aos="zoom-in" data-aos-duration="2000">
        <img src="assets/images/pngwing 4.png" class="img-fluid" alt="Dessert" loading="lazy" />
      </div>
      <div class="pt-1">Dessert</div>
    </a>
    <a href="./client_menu.php" class="col text-center text-decoration-none link-dark">
      <div class="category__img">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
        </svg>
      </div>
    </a>
  </div>
</div>
<!-- MENU -->

<!-- FOOTER -->
<div class="footerTemplate"></div>
<!-- FOOTER -->

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</html>

</html>