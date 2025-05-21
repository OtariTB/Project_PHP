<?php
include_once '../config/connect.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Store</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container header-container">
            <a href="./index.php" class="logo">MonitorStore</a>
            <div class="search-bar">
                <input type="text" placeholder="Search monitors... ">
            </div>
            <div class="nav-icons">
                <div class="nav-icon"><i class="fa-solid fa-circle-user"></i></div>
                <div class="nav-icon"><i class="fa-solid fa-heart"></i></div>
                <div class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            </div>
        </div>
        <nav class="main-nav">
            <div class="container nav-container">
                <ul class="nav-links">
                    <li><a href="">Gaming</a></li>
                    <li><a href="">Professional</a></li>
                    <li><a href="">Ultrawide</a></li>
                    <li><a href="">Budget</a></li>
                    <li><a href="">Deals</a></li>
                    <li><a href="./includes/products.php">Products</a></li>
                    <li><a href="./includes/login.php"> Log In</a></li>
                    <li><a href="./includes/register.php">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Our Monitors</h1>
            <p>Discover the perfect display for your needs</p>
        </div>
    </section>

</body>
</html>
