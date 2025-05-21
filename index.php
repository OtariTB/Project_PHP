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
    <section class="hero">
        <div class="container">
            <h1>Elevate Your Visual Experience</h1>
            <p>Discover our premium collection of monitors for gaming, professional work, and everyday use. Find the perfect display that meets your needs.</p>
            <a href="./includes/products.php" class="btn">Shop Now</a>
        </div>
    </section>

    <section class="categories">
        <div class="container">
            <h2 class="section-title">Browse Categories</h2>
            <div class="category-grid">
                <div class="category-card">
                    <div class="category-img">
                        <img src="./images/Gaming_Monitor.jpg" alt="Gaming Monitors">
                    </div>
                    <div class="category-info">
                        <h3>Gaming Monitors</h3>
                        <p>High refresh rates for competitive gaming</p>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="./images/Professional_Monitor.png" alt="Professional Monitors">
                    </div>
                    <div class="category-info">
                        <h3>Professional Monitors</h3>
                        <p>Color-accurate displays for creative work</p>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="./images/Ultrawide_Monitor.jpg" alt="Ultrawide Monitors">
                    </div>
                    <div class="category-info">
                        <h3>Ultrawide Monitors</h3>
                        <p>Expansive screens for immersive experiences</p>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="./images/Budget_Monitor.png" alt="Budget Monitors">
                    </div>
                    <div class="category-info">
                        <h3>Budget Monitors</h3>
                        <p>Quality displays at affordable prices</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Featured Monitors</h2>
            <div class="product-grid">
                <?php
                $sql = "SELECT * FROM PRODUCTS
                INNER JOIN resolutions on products.resolution_id = resolutions.id
                INNER JOIN brand on products.brand_id = brand.brand_id
                INNER JOIN categories on products.category_id = categories.category_id";
                $result = mysqli_query($conn, $sql);
                foreach ($result as $product) {
                    echo '
                    <div class="product-card">
                        <div class="product-img">
                            <img src="'.$product['image'].'" alt="'.$product['model'].'">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">'.$product['brandName']. " " ,$product['model'].'</h3>
                            <p class="product-specs">'. $product['resolution_type'].", ",$product['screen_size'].", ",$product['refresh_rate']."Hz, ",$product['panel'].'</p>
                            <div class="product-price">$'.$product['price'].'</div>
                            <a href="product.php?id='.$product['product_id'].'" class="product-btn"><i class="fa-solid fa-magnifying-glass"></i></a>
                            <a href="cart.php?add='.$product['product_id'].'" class="product-btn" style = "background-color : var(--light-green);"><i class="fa-solid fa-cart-plus"></i></a>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </section>
    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h3 class="feature-title">Free Shipping</h3>
                    <p>Free shipping on all orders over $100. Fast delivery to your doorstep.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-repeat"></i></div>
                    <h3 class="feature-title">30-Day Returns</h3>
                    <p>Not satisfied? Return within 30 days for a full refund.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3 class="feature-title">Secure Payment</h3>
                    <p>Your payment information is processed securely.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-links">
                    <h3>Shop</h3>
                    <ul>
                        <li><a href="gaming.php">Gaming Monitors</a></li>
                        <li><a href="professional.php">Professional Monitors</a></li>
                        <li><a href="ultrawide.php">Ultrawide Monitors</a></li>
                        <li><a href="budget.php">Budget Monitors</a></li>
                        <li><a href="deals.php">Special Deals</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="faq.php">FAQs</a></li>
                        <li><a href="shipping.php">Shipping Policy</a></li>
                        <li><a href="returns.php">Returns & Exchanges</a></li>
                        <li><a href="warranty.php">Warranty Information</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>About Us</h3>
                    <ul>
                        <li><a href="about.php">Our Story</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="careers.php">Careers</a></li>
                        <li><a href="reviews.php">Customer Reviews</a></li>
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
