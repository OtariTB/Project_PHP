<?php
include_once "../config/connect.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$check = $conn->prepare("SELECT id FROM users WHERE name = ? OR email = ?");
$check->bind_param("ss", $name, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<p style='color:red;'>Username or email already taken.</p>";
    echo "<a href='register.php'>Go back</a>";
} else {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<h2>Registration successful!</h2>";
        echo "<a href='login.php'>Go to Login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$check->close();
$conn->close();
?>