<?php
include_once './config/connect.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Store</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./includes/products.php">Products</a></li>
            </ul>
            <button>cart</button>

            <ul>
                <li><a href="./includes/login.php">login</a></li>
                <li><a href="./includes/register.php">register</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
