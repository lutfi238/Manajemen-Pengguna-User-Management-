<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include '../connect.php';

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>
<body>
    <h2>Profil Saya</h2>
    <p>
        <a href='../dashboard.php'>Dashboard</a> | 
        <a href='../product-management/view_all_products.php'>Products</a> | 
        <a href='../index.php'>Home</a>
    </p>
    <hr>
    
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><strong>Nama:</strong></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
        </tr>
        <tr>
            <td><strong>Role:</strong></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
        </tr>
        <tr>
            <td><strong>Status Akun:</strong></td>
            <td><?= $row['is_active'] ? 'Aktif ✓' : 'Tidak Aktif' ?></td>
        </tr>
        <tr>
            <td><strong>Terdaftar:</strong></td>
            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
        </tr>
    </table>
    
    <br>
    <p>
        <a href='edit_profile.php'><strong>Edit Profil</strong></a> | 
        <a href='../password-management/change_password.php'>Ubah Password</a>
    </p>
    <p><a href='logout.php'>Logout</a></p>
</body>
</html>
<?php

$conn->close();
?>

