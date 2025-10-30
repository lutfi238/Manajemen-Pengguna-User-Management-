<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: authentication/login.html');
    exit();
}

include 'connect.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];

// Get total products
$sql_total = "SELECT COUNT(*) as total FROM products WHERE user_id = $user_id";
$result_total = $conn->query($sql_total);
$total_products = $result_total->fetch_assoc()['total'];

// Get low stock products (stock < 10)
$sql_low = "SELECT COUNT(*) as low_stock FROM products WHERE user_id = $user_id AND stock < 10";
$result_low = $conn->query($sql_low);
$low_stock_count = $result_low->fetch_assoc()['low_stock'];

// Get recent products
$sql_recent = "SELECT product_name, product_code, stock, price, created_at FROM products 
               WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$result_recent = $conn->query($sql_recent);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Warehouse Management</title>
</head>
<body>
    <h1>Dashboard Admin Gudang</h1>
    <p>Selamat datang, <strong><?= htmlspecialchars($user_name) ?></strong>!</p>
    
    <p>
        <a href="dashboard.php">Dashboard</a> | 
        <a href="product-management/view_all_products.php">Products</a> | 
        <a href="authentication/profile.php">My Profile</a> | 
        <a href="authentication/logout.php">Logout</a>
    </p>
    <hr>
    
    <h2>Statistik Gudang</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td><strong>Total Produk:</strong></td>
            <td><?= $total_products ?> produk</td>
        </tr>
        <tr>
            <td><strong>Stok Rendah (< 10):</strong></td>
            <td style="<?= $low_stock_count > 0 ? 'color: red; font-weight: bold;' : '' ?>">
                <?= $low_stock_count ?> produk
                <?= $low_stock_count > 0 ? '⚠️' : '✓' ?>
            </td>
        </tr>
    </table>
    
    <br>
    <h3>Produk Terbaru</h3>
    <?php
    if ($result_recent->num_rows > 0) {
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>";
        echo "<th>Kode</th>";
        echo "<th>Nama Produk</th>";
        echo "<th>Stok</th>";
        echo "<th>Harga</th>";
        echo "<th>Ditambahkan</th>";
        echo "</tr>";
        
        while($row = $result_recent->fetch_assoc()) {
            $stock_class = ($row['stock'] < 10) ? "style='color: red;'" : "";
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['product_code']) . "</td>";
            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
            echo "<td $stock_class>" . $row['stock'] . "</td>";
            echo "<td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
            echo "<td>" . date('d-m-Y', strtotime($row['created_at'])) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p><em>Belum ada produk. <a href='product-management/add_product.php'>Tambah produk pertama</a></em></p>";
    }
    ?>
    
    <br>
    <h3>Menu Cepat</h3>
    <ul>
        <li><a href="product-management/view_all_products.php">Lihat Semua Produk</a></li>
        <li><a href="product-management/add_product.php">Tambah Produk Baru</a></li>
        <li><a href="authentication/profile.php">Edit Profil Saya</a></li>
        <li><a href="password-management/change_password.php">Ubah Password</a></li>
    </ul>
</body>
</html>

