<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System</title>
</head>
<body>
    <h1>Warehouse Management System</h1>
    <ul>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<li><a href='dashboard.php'>Dashboard</a></li>";
    echo "<li><a href='product-management/view_all_products.php'>Products</a></li>";
    echo "<li><a href='authentication/profile.php'>My Profile</a></li>";
    echo "<li><a href='authentication/logout.php'>Logout</a></li>";
} else {
    echo "<li><a href='registration/registration.php'>Register as Warehouse Admin</a></li>";
    echo "<li><a href='authentication/login.html'>Login</a></li>";
    echo "<li><a href='password-management/reset_password.html'>Forgot Password?</a></li>";
}
?>
    </ul>
</body>
</html></content>
<parameter name="filePath">c:\xampp\htdocs\webpro_intro\tugas_2_UTS\index.php