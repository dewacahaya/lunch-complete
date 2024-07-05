<?php
session_start();
include 'koneksi.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lunch.</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
  <!-- BOOTSTRAP -->

  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- FONT -->

  <!-- CSS -->
  <link rel="stylesheet" href="/styles/style.css" />
  <!-- CSS -->

  <!-- JQUERY -->
  <!-- JQUERY -->
</head>

<body>
  <!-- NAVBAR -->
  <div class="container-fluid p-0 bg-warning">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
      <ul class="nav col-12 col-md-auto justify-content-start ps-4 py-2 mb-md-0">
        <li>
          <a href="client_cart.php" class="nav-link px-2 px-lg-4 link-dark navbar_menu"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32  " fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
            </svg></a>
        </li>
        <li>
          <div class="nav-link fs-4 px-2 px-lg-4 link-dark navbar_menu">
            Personal Data
          </div>
        </li>
      </ul>
    </header>
  </div>
  <!-- NAVBAR -->

  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-md-6 mt-3 text-center">
        <h2>Complete your personal data to make delivery easier</h2>
        <img src="assets/images/pngegg (12) 1.png" class="img-fluid w-75" alt="gambar" />
      </div>

      <div class="col-md-6 my-auto bg-secondary-subtle p-3 rounded-4 mb-3">
        <form id="checkoutForm" action="" method="post">
          <div class="py-lg-2">
            <label for="">Name:</label>
            <input class="form-control" type="text" placeholder="Input Name" name="name" required />
          </div>
          <div class="py-lg-2">
            <label for="addrs">Address:</label>
            <input type="text" class="form-control" id="addrs" placeholder="Enter address" name="address" required />
          </div>
          <div class="py-lg-2">
            <label for="addrs">Phone Number:</label>
            <input type="number" class="form-control" id="num" placeholder="Enter phone number" name="number" required />
          </div>
          <div class="py-lg-2">
            <label for="" class="mb-2">Cart Details:</label>
            <div id="cart-details" class="bg-light p-3 rounded-3">
              <!-- Cart details akan tampil disini -->
            </div>
          </div>
          <div class="py-lg-2">
            <label for="" class="mb-2">Total Payment:</label>
            <div id="total-payment" class="bg-light p-3 rounded-3">
              <!-- Total payment akan tampil disini -->
            </div>
          </div>
          <div class="py-lg-2">
            <label for="" class="mb-2">Payment:</label>
            <select class="form-select" id="sel1" name="payment" required>
              <option value="COD">COD</option>
              <option value="Transfer Bank">Transfer Bank</option>
              <option value="E-Wallet">E-Wallet</option>
            </select>
          </div>
          <input type="hidden" name="cart" id="cartInput" value="">

          <div class="mx-auto d-flex justify-content-center mt-3">
            <input type="submit" name="submit" value="Done" class="btn text-dark fw-semibold btn-warning px-5 py-2 rounded-3">
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['submit'])) {


    $name = $_POST['name'];
    $alamat = $_POST['address'];
    $no_hp = $_POST['number'];
    $payment = $_POST['payment'];

    // Validasi dan set nilai pembayaran
    $payment_list = array(
      "COD" => "COD",
      "Transfer Bank" => "Transfer Bank",
      "E-Wallet" => "E-Wallet"
    );

    $payment_fix = isset($payment_list[$payment]) ? $payment_list[$payment] : '';

    // Cek apakah customer sudah ada berdasarkan nama, alamat, dan nomor telepon
    $check_cust = mysqli_query($conn, "SELECT cust_id FROM tb_cust WHERE cust_name='$name' AND cust_address='$alamat' AND cust_phone='$no_hp'");
    if (mysqli_num_rows($check_cust) > 0) {
      $cust_data = mysqli_fetch_assoc($check_cust);
      $cust_id = $cust_data['cust_id'];
    } else {
      // Query untuk menyisipkan data ke dalam tabel tb_cust
      $insert_cust = mysqli_query($conn, "INSERT INTO tb_cust (cust_name, cust_address, cust_phone, payment) VALUES ('$name', '$alamat', '$no_hp', '$payment_fix')");
      if ($insert_cust) {
        $cust_id = mysqli_insert_id($conn);
      } else {
        echo 'Gagal menyimpan data customer: ' . mysqli_error($conn);
        exit();
      }
    }

    // Simpan data transaksi ke tabel tb_penjualan
    $insert_sale = mysqli_query($conn, "INSERT INTO tb_penjualan (cust_id,cust_name, sale_date) VALUES ('$cust_id', '$name', NOW())");
    if ($insert_sale) {
      // Ambil ID transaksi yang baru disimpan
      $sale_id = mysqli_insert_id($conn);

      // Ambil data cart dari localStorage
      $cart = json_decode($_POST['cart'], true);

      // Simpan detail transaksi ke tabel tb_detail_penjualan
      foreach ($cart as $product) {
        $product_name = $product['name'];
        $product_price = $product['price'];
        $quantity = $product['quantity'];

        // Ambil product_id berdasarkan nama produk
        $get_product_id = mysqli_query($conn, "SELECT product_id FROM tb_product WHERE product_name='$product_name'");
        if (mysqli_num_rows($get_product_id) > 0) {
          $product_data = mysqli_fetch_assoc($get_product_id);
          $product_id = $product_data['product_id'];

          $insert_detail = mysqli_query($conn, "INSERT INTO detail_penjualan (sale_id, product_id, product_name, product_price, quantity) VALUES ('$sale_id', '$product_id', '$product_name', '$product_price', '$quantity')");
          if (!$insert_detail) {
            echo 'Gagal menyimpan detail penjualan: ' . mysqli_error($conn);
            exit();
          }
        } else {
          echo 'Produk tidak ditemukan: ' . $product_name;
          exit();
        }
      }

      echo '<script>alert("Berhasil Checkout")</script>';
      echo '<script>window.location="client_lastpage.html"</script>';
    } else {
      echo 'Gagal menyimpan data penjualan: ' . mysqli_error($conn);
    }

    // Tutup koneksi database
    mysqli_close($conn);

    // Hapus data cart dari localStorage
    echo '<script>localStorage.clear();</script>';
  }
  ?>




  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const cartDetailsElement = document.getElementById('cart-details');
      const totalPaymentElement = document.getElementById('total-payment');
      const cartInputElement = document.getElementById('cartInput');

      // Function to display cart details and total payment
      function displayCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalPayment = 0;

        // Clear previous content
        cartDetailsElement.innerHTML = '';
        totalPaymentElement.innerHTML = '';

        cart.forEach(product => {
          const productElement = document.createElement('div');
          productElement.className = 'mb-2';
          productElement.innerHTML = `
                <div><strong>Name:</strong> ${product.name}</div>
                <div><strong>Price:</strong> Rp. ${product.price}</div>
                <div><strong>Quantity:</strong> ${product.quantity}</div>
            `;
          cartDetailsElement.appendChild(productElement);
          totalPayment += product.price * product.quantity;
        });

        totalPaymentElement.innerHTML = `Rp. ${totalPayment.toLocaleString()}`;
        cartInputElement.value = JSON.stringify(cart);
      }

      // Display the cart when the page loads
      displayCart();

      // Handle form submission
      const form = document.getElementById('checkoutForm');
      form.addEventListener('submit', function(event) {
        // Hapus data cart dari localStorage
        localStorage.clear();
      });
    });
  </script>

</body>

</html>