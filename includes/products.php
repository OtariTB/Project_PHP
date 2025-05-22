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
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Our Monitors</h1>
            <p>Discover the perfect display for your needs</p>
        </div>
    </section>
    <main class="container">
        <div class="filter-section">
        <form method="GET" class="filter-controls" id="filterForm">
            <select class="filter-select" name="sort" onchange="document.getElementById('filterForm').submit();">
                <option value="">Sort By</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="popular">Most Popular</option>
            </select>
            <select class="filter-select" name="screen_size" onchange="document.getElementById('filterForm').submit();">
                <option value="">Screen Size</option>
                <option value="24">24 inch</option>
                <option value="27">27 inch</option>
                <option value="32">32 inch</option>
                <option value="34">34+ inch</option>
            </select>
            <select class="filter-select" name="resolutions" onchange="document.getElementById('filterForm').submit();">
                <option value="">Resolution</option>
                <option value="1920 x 1080 (FHD)">Full HD (1080p)</option>
                <option value="2560 x 1440 (2K)">2K (1440p)</option>
                <option value="3840 x 2160 (4K)">4K Ultra HD</option>
            </select>
            <select class="filter-select" name="panel" onchange="document.getElementById('filterForm').submit();">
                <option value="">Panel Type</option>
                <option value="ips">IPS</option>
                <option value="va">VA</option>
                <option value="oled">OLED</option>
            </select>
            <select class="filter-select" name="category" onchange="document.getElementById('filterForm').submit();">
                <option value="">Category</option>
                <option value="Gaming">Gaming</option>
                <option value="Professional">Professional</option>
                <option value="Ultrawide">Ultrawide</option>
                <option value="Budget">Budget</option>
            </select>
        </form>
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Search monitors...">
                <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    <div class="products-grid">
    <?php

    $query = "SELECT * FROM PRODUCTS
            INNER JOIN resolutions on products.resolution_id = resolutions.id
            INNER JOIN brand on products.brand_id = brand.brand_id
            INNER JOIN categories on products.category_id = categories.category_id";
    

    $conditions = array();
    if(isset($_GET['resolutions']) && !empty($_GET['resolutions'])) {
        $resolution = mysqli_real_escape_string($conn, $_GET['resolutions']);
        $conditions[] = "resolution_type = '$resolution'";
    }
    if(isset($_GET['screen_size']) && !empty($_GET['screen_size'])) {
        $screen_size = mysqli_real_escape_string($conn, $_GET['screen_size']);
        $conditions[] = "screen_size = '$screen_size'";
    }
    if(isset($_GET['panel']) && !empty($_GET['panel'])) {
        $panel = mysqli_real_escape_string($conn, $_GET['panel']);
        $conditions[] = "panel = '$panel'";
    }
    if(isset($_GET['category']) && !empty($_GET['category'])) {
        $category = mysqli_real_escape_string($conn, $_GET['category']);
        $conditions[] = "categoryName = '$category'";
    }
    if(count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    if(isset($_GET['sort'])) {
        switch($_GET['sort']) {
            case 'price-low':
                $query .= " ORDER BY price ASC";
                break;
            case 'price-high':
                $query .= " ORDER BY price DESC";
                break;
            case 'newest':
                $query .= " ORDER BY product_id DESC";
                break;
            case 'popular':
                $query .= " ORDER BY popularity DESC";
                break;
            default:
                $query .= " ORDER BY product_id DESC";
        }
    } else {
        $query .= " ORDER BY product_id DESC"; 
    }
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
            $stockClass = "out-of-stock";
            $stockText = "Out of Stock";
            
            if($product['quantity'] > 10) {
                $stockClass = "in-stock";
                $stockText = "In Stock";
            } elseif($product['quantity'] > 0) {
                $stockClass = "low-stock";
                $stockText = "Low Stock";
            }
    ?>
    
    <div class="product-card">
        <a href="./single_page.php?id=<?php echo $product['product_id']; ?>" style="text-decoration: none;">
        <img src=".<?php echo htmlspecialchars($product['image']); ?>" 
             alt="<?php echo htmlspecialchars($product['brandName']); ?>" 
             class="product-img">
        </a>
        <div class="product-info">
            <div class="product-category"><?php echo htmlspecialchars($product['categoryName']); ?></div>
            <h3 class="product-name"><?php echo htmlspecialchars($product['brandName']) . " " . htmlspecialchars($product['model']); ?></h3>
            
            <div class="product-specs">
                <div class="spec-item">
                    <span class="spec-icon"><i class="fa-solid fa-chart-bar"></i></span>
                    <span><?php echo htmlspecialchars($product['screen_size']); ?>-inch, <?php echo htmlspecialchars($product['resolution_type']); ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-icon"><i class="fa-solid fa-gauge"></i></span>
                    <span><?php echo htmlspecialchars($product['refresh_rate']); ?>Hz</span>
                </div>
                <div class="spec-item">
                    <span class="spec-icon"><i class="fa-solid fa-image"></i></span>
                    <span><?php echo htmlspecialchars($product['panel']); ?> Panel</span>
                </div>
            </div>
            
            <div class="stock-status <?php echo $stockClass; ?>"><?php echo $stockText; ?></div>
            
            <div class="product-footer">
                <div class="price">
                    <?php if(!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                    <span class="discount">$<?php echo number_format($product['old_price'], 2); ?></span>
                    <?php endif; ?>
                    $<?php echo number_format($product['price'], 2); ?>
                </div>
                
                <button class="add-to-cart" 
                        <?php echo ($product['quantity'] <= 0) ? 'disabled' : ''; ?>
                        data-product-id="<?php echo $product['id']; ?>">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
    
    <?php
        }
    } else {
        echo '<div class="no-products">No monitors found matching your criteria.</div>';
    }
    ?>
</div>

</main>
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-links">
                    <h3>Shop</h3>
                    <ul>
                        <li><a href="./products.php?category=Gaming">Gaming Monitors</a></li>
                        <li><a href="./products.php?category=Professional">Professional Monitors</a></li>
                        <li><a href="./products.php?category=Ultrawide">Ultrawide Monitors</a></li>
                        <li><a href="./products.php?category=Budget">Budget Monitors</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">FAQs</a></li>
                        <li><a href="">Shipping Policy</a></li>
                        <li><a href="">Returns & Exchanges</a></li>
                        <li><a href="">Warranty Information</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>About Us</h3>
                    <ul>
                        <li><a href="">Our Story</a></li>
                        <li><a href="">Blog</a></li>
                        <li><a href="">Careers</a></li>
                        <li><a href="">Customer Reviews</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Connect With Us</h3>
                    <p>Follow us on social media for news and updates.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> MonitorStore. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
