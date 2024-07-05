<?php
session_start();
session_destroy();
echo '<script>
        alert("Kamu Sudah Logout!");
        window.location.href="login.php";
    </script>';
