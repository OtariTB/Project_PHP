<?php
include_once "./config/connect.php";
session_start();

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['user_type'] = $user['user_type'];
?>