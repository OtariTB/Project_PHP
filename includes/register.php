<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Monitor Store</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
        <header>
        <div class="container header-container">
            <a href="../index.php" class="logo">MonitorStore</a>
        </div>
        <nav class="main-nav">
            <div class="container nav-container">
                <ul class="nav-links">
                    <li><a href="./products.php?category=Gaming">Gaming</a></li>
                    <li><a href="./products.php?category=Professional">Professional</a></li>
                    <li><a href="./products.php?category=Ultrawide">Ultrawide</a></li>
                    <li><a href="./products.php?category=Budget">Budget</a></li>
                    <li><a href="./products.php">Products</a></li>
                    <li><a href="./login.php"> Log In</a></li>
                    <li><a href="./register.php">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>
        <section class="page-header">
        <div class="container">
            <h1 class="page-title">Sign Up</h1>
            <p>Sign up to our Website to add items to cart, make orders and more</p>
        </div>
    </section>
    <div class="login-container">
        <div class="login-header">
            <h1>Monitor Store</h1>
            <p>Please sign in to continue</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="./register_logic.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" value="" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="login-button">Sign Up</button>
            <p>Already have an Account? <a href="./login.php">Log In</a></p>
        </form>
    </div>

    
</body>
</html>