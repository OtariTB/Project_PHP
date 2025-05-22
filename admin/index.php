<?php
include_once "../config/connect.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    die("Access denied. Admins only.");
}

$action = $_GET['action'] ?? 'dashboard';
$table = $_GET['table'] ?? null;
$message = '';
$edit_data = null;

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

// Dashboard counts
$product_count = 0;
$user_count = 0;
$brand_count = 0;
$category_count = 0;
$resolution_count = 0;
if ($action === 'dashboard') {
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
    $row = mysqli_fetch_assoc($result);
    $product_count = $row['count'] ?? 0;

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $row = mysqli_fetch_assoc($result);
    $user_count = $row['count'] ?? 0;

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM brand");
    $row = mysqli_fetch_assoc($result);
    $brand_count = $row['count'] ?? 0;

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM categories");
    $row = mysqli_fetch_assoc($result);
    $category_count = $row['count'] ?? 0;

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM resolutions");
    $row = mysqli_fetch_assoc($result);
    $resolution_count = $row['count'] ?? 0;
}

    if ($table) {
        if (isset($_POST['create'])) {
            if ($table === 'products') {
                $category_id = $_POST['category_id'] ?? 0;
                $brand_id = $_POST['brand_id'] ?? 0;
                $model = $_POST['model'] ?? '';
                $screen_size = $_POST['screen_size'] ?? 0;
                $resolution_id = $_POST['resolution_id'] ?? 0;
                $panel = $_POST['panel'] ?? '';
                $refresh_rate = $_POST['refresh_rate'] ?? 0;
                $price = $_POST['price'] ?? 0;
                $quantity = $_POST['quantity'] ?? 0;
                $image = $_POST['image'] ?? '';
                $isFeatured = $_POST['isFeatured'] ?? 0;

                $stmt = $conn->prepare("INSERT INTO products (category_id, brand_id, model, screen_size, resolution_id, panel, refresh_rate, price, quantity, image, isFeatured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iisiisidiss", $category_id, $brand_id, $model, $screen_size, $resolution_id, $panel, $refresh_rate, $price, $quantity, $image, $isFeatured);
                if ($stmt->execute()) {
                    $message = "Product added successfully.";
                } else {
                    $message = "Error adding product: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'users') {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $password);
                if ($stmt->execute()) {
                    $message = "User added successfully.";
                } else {
                    $message = "Error adding user: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'resolutions') {
                $resolution_type = $_POST['resolution_type'] ?? '';

                $stmt = $conn->prepare("INSERT INTO resolutions (resolution_type) VALUES (?)");
                $stmt->bind_param("s", $resolution_type);
                if ($stmt->execute()) {
                    $message = "Resolution added successfully.";
                } else {
                    $message = "Error adding resolution: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'category') {
                $categoryName = $_POST['categoryName'] ?? '';
                $description = $_POST['description'] ?? '';

                $stmt = $conn->prepare("INSERT INTO categories (categoryName, description) VALUES (?, ?)");
                $stmt->bind_param("ss", $categoryName, $description);
                if ($stmt->execute()) {
                    $message = "Category added successfully.";
                } else {
                    $message = "Error adding category: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'brand') {
                $brandName = $_POST['brandName'] ?? '';

                $stmt = $conn->prepare("INSERT INTO brand (brandName) VALUES (?)");
                $stmt->bind_param("s", $brandName);
                if ($stmt->execute()) {
                    $message = "Brand added successfully.";
                } else {
                    $message = "Error adding brand: " . $stmt->error;
                }
                $stmt->close();
            }
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'] ?? 0;
            if ($table === 'products') {
                $category_id = $_POST['category_id'] ?? 0;
                $brand_id = $_POST['brand_id'] ?? 0;
                $model = $_POST['model'] ?? '';
                $screen_size = $_POST['screen_size'] ?? 0;
                $resolution_id = $_POST['resolution_id'] ?? 0;
                $panel = $_POST['panel'] ?? '';
                $refresh_rate = $_POST['refresh_rate'] ?? 0;
                $price = $_POST['price'] ?? 0;
                $quantity = $_POST['quantity'] ?? 0;
                $image = $_POST['image'] ?? '';
                $isFeatured = $_POST['isFeatured'] ?? 0;

                $stmt = $conn->prepare("UPDATE products SET category_id=?, brand_id=?, model=?, screen_size=?, resolution_id=?, panel=?, refresh_rate=?, price=?, quantity=?, image=?, isFeatured=? WHERE product_id=?");
                $stmt->bind_param("iisiisidissi", $category_id, $brand_id, $model, $screen_size, $resolution_id, $panel, $refresh_rate, $price, $quantity, $image, $isFeatured, $id);
                if ($stmt->execute()) {
                    $message = "Product updated successfully.";
                } else {
                    $message = "Error updating product: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'users') {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                if (!empty($password)) {
                    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
                    $stmt->bind_param("sssi", $name, $email, $password, $id);
                } else {
                    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
                    $stmt->bind_param("ssi", $name, $email, $id);
                }
                if ($stmt->execute()) {
                    $message = "User updated successfully.";
                } else {
                    $message = "Error updating user: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'resolutions') {
                $resolution_type = $_POST['resolution_type'] ?? '';

                $stmt = $conn->prepare("UPDATE resolutions SET resolution_type=? WHERE id=?");
                $stmt->bind_param("si", $resolution_type, $id);
                if ($stmt->execute()) {
                    $message = "Resolution updated successfully.";
                } else {
                    $message = "Error updating resolution: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'category') {
                $categoryName = $_POST['categoryName'] ?? '';
                $description = $_POST['description'] ?? '';

                $stmt = $conn->prepare("UPDATE categories SET categoryName=?, description=? WHERE category_id=?");
                $stmt->bind_param("ssi", $categoryName, $description, $id);
                if ($stmt->execute()) {
                    $message = "Category updated successfully.";
                } else {
                    $message = "Error updating category: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'brand') {
                $brandName = $_POST['brandName'] ?? '';

                $stmt = $conn->prepare("UPDATE brand SET brandName=? WHERE brand_id=?");
                $stmt->bind_param("si", $brandName, $id);
                if ($stmt->execute()) {
                    $message = "Brand updated successfully.";
                } else {
                    $message = "Error updating brand: " . $stmt->error;
                }
                $stmt->close();
            }
        }

        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            if ($table === 'products') {
                $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Product deleted successfully.";
                } else {
                    $message = "Error deleting product: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'users') {
                $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "User deleted successfully.";
                } else {
                    $message = "Error deleting user: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'resolutions') {
                $stmt = $conn->prepare("DELETE FROM resolutions WHERE id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Resolution deleted successfully.";
                } else {
                    $message = "Error deleting resolution: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'category') {
                $stmt = $conn->prepare("DELETE FROM categories WHERE category_id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Category deleted successfully.";
                } else {
                    $message = "Error deleting category: " . $stmt->error;
                }
                $stmt->close();
            } elseif ($table === 'brand') {
                $stmt = $conn->prepare("DELETE FROM brand WHERE brand_id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Brand deleted successfully.";
                } else {
                    $message = "Error deleting brand: " . $stmt->error;
                }
                $stmt->close();
            }
        }

        // Handle edit
        if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($table === 'products') {
                $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $edit_data = $result->fetch_assoc();
                $stmt->close();
            } elseif ($table === 'users') {
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $edit_data = $result->fetch_assoc();
                $stmt->close();
            } elseif ($table === 'resolutions') {
                $stmt = $conn->prepare("SELECT * FROM resolutions WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $edit_data = $result->fetch_assoc();
                $stmt->close();
            } elseif ($table === 'category') {
                $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $edit_data = $result->fetch_assoc();
                $stmt->close();
            } elseif ($table === 'brand') {
                $stmt = $conn->prepare("SELECT * FROM brand WHERE brand_id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $edit_data = $result->fetch_assoc();
                $stmt->close();
            }
        }

        // Fetch records
        $records = [];
        if ($table === 'products') {
            $result = mysqli_query($conn, "SELECT * FROM products");
            $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } elseif ($table === 'users') {
            $result = mysqli_query($conn, "SELECT * FROM users");
            $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } elseif ($table === 'resolutions') {
            $result = mysqli_query($conn, "SELECT * FROM resolutions");
            $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } elseif ($table === 'category') {
            $result = mysqli_query($conn, "SELECT * FROM categories");
            $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } elseif ($table === 'brand') {
            $result = mysqli_query($conn, "SELECT * FROM brand");
            $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="?action=dashboard" class="<?= $action == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
                <li><a href="?action=manage&table=products" class="<?= $table == 'products' ? 'active' : '' ?>">Products</a></li>
                <li><a href="?action=manage&table=users" class="<?= $table == 'users' ? 'active' : '' ?>">Users</a></li>
                <li><a href="?action=manage&table=resolutions" class="<?= $table == 'resolutions' ? 'active' : '' ?>">Resolutions</a></li>
                <li><a href="?action=manage&table=category" class="<?= $table == 'category' ? 'active' : '' ?>">Category</a></li>
                <li><a href="?action=manage&table=brand" class="<?= $table == 'brand' ? 'active' : '' ?>">Brand</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h1>Admin Dashboard</h1>
                <a href="?logout=1" class="logout-btn">Logout</a>
                <div style="clear: both;"></div>
            </div>
            
            <?php if ($action == 'dashboard'): ?>
                <div class="stats">
                    <div class="stat-card">
                        <h3>Total Products</h3>
                        <div class="number"><?= $product_count ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Users</h3>
                        <div class="number"><?= $user_count ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Brands</h3>
                        <div class="number"><?= $brand_count ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Categories</h3>
                        <div class="number"><?= $category_count ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Resolutions</h3>
                        <div class="number"><?= $resolution_count ?></div>
                    </div>
                </div>
                
                <div class="content">
                    <h2>Welcome to Admin Panel</h2>
                    <p>Use the sidebar to navigate between different sections.</p>
                </div>
                
            <?php else: ?>
                <div class="content">
                    <?php if ($message): ?>
                        <div class="message"><?= $message ?></div>
                    <?php endif; ?>
                    
                    <h2><?= ucfirst($table) ?> Management</h2>
                    
                    <form method="POST">
                        <div class="form-grid">
                            <?php if ($table == 'products'): ?>
                                <div class="form-group">
                                    <label>Category ID</label>
                                    <input type="number" name="category_id" value="<?= $edit_data['category_id'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Brand ID</label>
                                    <input type="number" name="brand_id" value="<?= $edit_data['brand_id'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" value="<?= $edit_data['model'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Screen Size</label>
                                    <input type="number" name="screen_size" value="<?= $edit_data['screen_size'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Resolution ID</label>
                                    <input type="number" name="resolution_id" value="<?= $edit_data['resolution_id'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Panel</label>
                                    <input type="text" name="panel" value="<?= $edit_data['panel'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Refresh Rate</label>
                                    <input type="number" name="refresh_rate" value="<?= $edit_data['refresh_rate'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price" value="<?= $edit_data['price'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" value="<?= $edit_data['quantity'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="text" name="image" value="<?= $edit_data['image'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Is Featured</label>
                                    <input type="number" name="isFeatured" value="<?= $edit_data['isFeatured'] ?? '' ?>" required>
                                </div>
                            <?php elseif ($table == 'users'): ?>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="name" value="<?= $edit_data['name'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= $edit_data['email'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Password <?= $edit_data ? '(leave empty to keep current)' : '' ?></label>
                                    <input type="password" name="password" <?= !$edit_data ? 'required' : '' ?>>
                                </div>
                            <?php elseif ($table == 'resolutions'): ?>
                                <div class="form-group">
                                    <label>Resolution Type</label>
                                    <input type="text" name="resolution_type" value="<?= $edit_data['resolution_type'] ?? '' ?>" required>
                                </div>
                            <?php elseif ($table == 'category'): ?>
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="categoryName" value="<?= $edit_data['categoryName'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" required><?= $edit_data['description'] ?? '' ?></textarea>
                                </div>
                            <?php elseif ($table == 'brand'): ?>
                                <div class="form-group">
                                    <label>Brand Name</label>
                                    <input type="text" name="brandName" value="<?= $edit_data['brandName'] ?? '' ?>" required>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id" value="<?= $table === 'products' ? $edit_data['product_id'] : ($table === 'category' ? $edit_data['category_id'] : ($table === 'brand' ? $edit_data['brand_id'] : $edit_data['id'])) ?>">
                            <button type="submit" name="update" class="btn btn-success">Update <?= ucfirst(rtrim($table, 's')) ?></button>
                            <a href="?table=<?= $table ?>" class="btn btn-secondary">Cancel</a>
                        <?php else: ?>
                            <button type="submit" name="create" class="btn btn-primary">Add <?= ucfirst(rtrim($table, 's')) ?></button>
                        <?php endif; ?>
                    </form>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <?php if ($table == 'products'): ?>
                                        <th>Category ID</th>
                                        <th>Brand ID</th>
                                        <th>Model</th>
                                        <th>Screen Size</th>
                                        <th>Resolution ID</th>
                                        <th>Panel</th>
                                        <th>Refresh Rate</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        <th>Is Featured</th>
                                    <?php elseif ($table == 'users'): ?>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                    <?php elseif ($table == 'resolutions'): ?>
                                        <th>Resolution_Type</th>
                                    <?php elseif ($table == 'category'): ?>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                    <?php elseif ($table == 'brand'): ?>
                                        <th>Brand Name</th>
                                    <?php endif; ?>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $record): ?>
                                    <tr>
                                        
                                        <?php if ($table == 'products'): ?>
                                            <td><?= $record['product_id'] ?></td>
                                            <td><?= htmlspecialchars($record['category_id']) ?></td>
                                            <td><?= htmlspecialchars($record['brand_id']) ?></td>
                                            <td><?= htmlspecialchars($record['model']) ?></td>
                                            <td><?= htmlspecialchars($record['screen_size']) ?></td>
                                            <td><?= htmlspecialchars($record['resolution_id']) ?></td>
                                            <td><?= htmlspecialchars($record['panel']) ?></td>
                                            <td><?= htmlspecialchars($record['refresh_rate']) ?></td>
                                            <td>$<?= number_format($record['price'], 2) ?></td>
                                            <td><?= htmlspecialchars($record['quantity']) ?></td>
                                            <td><?= htmlspecialchars($record['image']) ?></td>
                                            <td><?= htmlspecialchars($record['isFeatured']) ?></td>
                                    <?php elseif ($table == 'users'): ?>
                                        <td><?= $record['id'] ?></td>
                                        <td><?= htmlspecialchars($record['name']) ?></td>
                                        <td><?= htmlspecialchars($record['email']) ?></td>
                                        <td><?= $record['password'] ?? 'N/A' ?></td>
                                    <?php elseif ($table == 'resolutions'): ?>
                                        <td><?= $record['id'] ?></td>
                                        <td><?= htmlspecialchars($record['resolution_type']) ?></td>
                                    <?php elseif ($table == 'category'): ?>
                                        <td><?= $record['category_id'] ?></td>
                                        <td><?= htmlspecialchars($record['categoryName']) ?></td>
                                        <td><?= htmlspecialchars($record['description']) ?></td>
                                    <?php elseif ($table == 'brand'): ?>
                                        <td><?= $record['brand_id'] ?></td>
                                        <td><?= htmlspecialchars($record['brandName']) ?></td>
                                    <?php endif; ?>
                                        <td>
                                            <a href="?table=<?= $table ?>&action=edit&id=<?= $table === 'products' ? $record['product_id'] : ($table === 'category' ? $record['category_id'] : ($table === 'brand' ? $record['brand_id'] : $record['id'])) ?>" class="btn btn-primary">Edit</a>
                                            <a href="?table=<?= $table ?>&delete=<?= $table === 'products' ? $record['product_id'] : ($table === 'category' ? $record['category_id'] : ($table === 'brand' ? $record['brand_id'] : $record['id'])) ?>" 
                                               class="btn btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this <?= rtrim($table, 's') ?>?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
