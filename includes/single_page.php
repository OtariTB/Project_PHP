<?php
include_once '../config/connect.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id === 0) {
    die("Invalid product ID");
}

// Fetch product data
$sql = "SELECT * FROM PRODUCTS
            INNER JOIN resolutions on products.resolution_id = resolutions.id
            INNER JOIN brand on products.brand_id = brand.brand_id
            INNER JOIN categories on products.category_id = categories.category_id 
            WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found");
}
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
            <a href="../index.php" class="logo">MonitorStore</a>
            <div class="search-bar">
                <input type="text" placeholder="Search monitors... ">
            </div>
            <div class="nav-icons">
                <div class="nav-icon"><i class="fa-solid fa-circle-user"></i></div>
                <div class="nav-icon"><a href="./login.php"><i class="fa-solid fa-right-to-bracket"></i></a></div>
                <div class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            </div>
        </div>
        <nav class="main-nav">
            <div class="container nav-container">
                <ul class="nav-links">
                    <li><a href="./products.php?category=Gaming">Gaming</a></li>
                    <li><a href="./products.php?category=Professional">Professional</a></li>
                    <li><a href="./products.php?category=Ultrawide">Ultrawide</a></li>
                    <li><a href="./products.php?category=Budget">Budget</a></li>
                    <li><a href="./products.php">Products</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <a href="./products.php" class="back-button">← Back to Products</a>
        
        <div class="product-container">
            <div class="product-header">
                <div class="product-image">
                    <img src=".<?php echo htmlspecialchars($product['image'] ?? 'images/default-monitor.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($product['brandName']); ?>">
                </div>
                
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($product['brandName'])," " . $product['model']; ?></h1>
                    
                    <div class="stock-status <?php echo ($product['quantity'] ?? 0) > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                        <?php echo ($product['quantity'] ?? 0) > 0 ? 'In Stock' : 'Out of Stock'; ?>
                    </div>
                    
                    <div class="product-price">
                        $<?php echo number_format($product['price'] ?? 0, 2); ?>
                    </div>
                    
                    <div class="product-description">
                        <?php echo nl2br(htmlspecialchars($product['description'] ?? 'No description available.')); ?>
                    </div>
                    
                    <button class="buy-button" <?php echo ($product['quantity'] ?? 0) <= 0 ? 'disabled' : ''; ?>>
                        <?php echo ($product['quantity'] ?? 0) > 0 ? 'Add to Cart' : 'Out of Stock'; ?>
                    </button>
                </div>
            </div>
            
            <div class="specifications">
                <h2 class="specs-title">Specifications</h2>
                
                <div class="specs-grid">
                    <div class="spec-category">
                        <h3>Display</h3>
                        <div class="spec-item">
                            <span class="spec-label">Screen Size</span>
                            <span class="spec-value"> <?php echo htmlspecialchars($product['screen_size'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Resolution</span>
                            <span class="spec-value"><?php echo htmlspecialchars($product['resolution_type'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Panel Type</span>
                            <span class="spec-value"><?php echo htmlspecialchars($product['panel'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Refresh Rate</span>
                            <span class="spec-value"><?php echo htmlspecialchars($product['refresh_rate'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
