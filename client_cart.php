<?php
session_start();
include 'koneksi.php';
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
  <link rel="stylesheet" href="css/clients_style.css" />
  <!-- CSS -->
</head>

<body>
  <!-- NAVBAR -->
  <div class="container-fluid p-0 bg-warning">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
      <ul class="nav col-12 col-md-auto justify-content-start ps-4 py-2 mb-md-0">
        <li>
          <a href="./client_menu.php" class="nav-link px-2 px-lg-4 link-dark navbar_menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
            </svg>
          </a>
        </li>
        <li>
          <div class="nav-link fs-4 px-2 px-lg-4 link-dark navbar_menu">
            Cart
          </div>
        </li>
      </ul>
    </header>
  </div>
  <!-- NAVBAR -->

  <div class="container-fluid p-0">
    <div class="row mx-auto bg-light mt-3 p-2" id="cart-items">
      <!-- Cart item akan tampil otomatis disini -->
    </div>
  </div>

  <div class="container-fluid bg-warning mt-3 fixed-bottom">
    <div class="row">
      <div class="col-6 d-flex">
        <p class="my-3 fw-bold">Total</p>
      </div>
      <div class="col-3">
        <p class="my-3 text-start" id="total-price">Rp. 0</p>
      </div>
      <div id="buy_button" class="col-3 d-flex align-items-center justify-content-center fw-semibold text-center bg-danger bg-opacity-50">
        <a href="client_data.php" class="text-decoration-none text-dark">Buy All</a>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const cartItemsContainer = document.getElementById('cart-items');
      const totalPriceElement = document.getElementById('total-price');

      function displayCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItemsContainer.innerHTML = '';

        if (cart.length === 0) {
          cartItemsContainer.innerHTML = '<p class="text-center my-5">Your cart is empty.</p>';
        } else {
          let totalPrice = 0;
          cart.forEach((item, index) => {
            totalPrice += parseFloat(item.price) * item.quantity;
            const itemElement = document.createElement('div');
            itemElement.classList.add('col-12', 'mb-3');
            itemElement.innerHTML = `
              <div class="d-flex align-items-center">
                <div class="col-4 container mt-3 d-flex align-items-center justify-content-center">
                  <img src="img/${item.image}" id="image_cart" class="img-fluid w-50 h-50" alt="${item.name}" />
                </div>
                <div class="col-8 container mt-3">
                  <div class="row">
                    <div class="col-10 mb-5">
                      <h4 class="fs-3 fw-semibold mb-3">${item.name}</h4>
                      <span class="fs-5">Rp. ${new Intl.NumberFormat().format(item.price)}</span>
                      <div class="d-flex flex-wrap justify-content-start align-items-center mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-dash" style="cursor: pointer" viewBox="0 0 16 16" onclick="updateQuantity(${index}, -1)">
                          <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                        </svg>
                        <div class="bg-opacity-50 px-2 fw-bold">
                          <input type="number" min="1" max="100" value="${item.quantity}" style="text-align: center; font-weight: bold; border: none" onchange="updateQuantity(${index}, 0, this.value)" />
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus" style="cursor: pointer" viewBox="0 0 16 16" onclick="updateQuantity(${index}, 1)">
                          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                      </div>
                    </div>
                    <div class="col-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-lg" style="cursor: pointer" viewBox="0 0 16 16" onclick="removeItem(${index})">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row container-fluid p-0 m-0">
                <div class="col-4"></div>
                <div class="col-8 bg-secondary bg-opacity-50 fs-6 py-2">
                  <div class="row">
                    <div class="col-6">Subtotal:</div>
                    <div class="col-6 text-end">Rp. ${new Intl.NumberFormat().format((parseFloat(item.price) * item.quantity).toFixed(2))}</div>
                  </div>
                </div>
              </div>
            `;
            cartItemsContainer.appendChild(itemElement);
          });

          totalPriceElement.textContent = `Rp. ${new Intl.NumberFormat().format(totalPrice.toFixed(2))}`;
        }
      }

      window.updateQuantity = function(index, change, value) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (change !== 0) {
          cart[index].quantity += change;
        } else {
          cart[index].quantity = parseInt(value);
        }
        if (cart[index].quantity <= 0) {
          cart[index].quantity = 1;
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();
      }

      window.removeItem = function(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();
      }

      displayCart();
    });
  </script>
</body>

</html>