<?php
session_start();
include_once '../config/connect.php';

$error = '';
$name = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    if (empty($name) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $sql = "SELECT * FROM users WHERE name = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt-> bind_param("ss", $name, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['user_type'] = $user['isadmin'];
            echo "<h2 style = 'margin : 0 auto;'>Welcome, " . htmlspecialchars($user['name']) . "!</h2>";
            header("Location: ../index.php");
        } else {
            echo "<span style='color : red; font-size: 1rem;'> Incorrect Username or Password</span>";
        }
        $stmt->close();
    }
}
?>

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
            <h1 class="page-title">Log In</h1>
            <p>Log In into our Website to add items to cart, make orders and more</p>
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
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="login-button">Sign In</button>
        </form>
        <p>Dont have an Account? <a href="./register.php">Sing Up</a></p>
    </div>
</body>
</html>
