<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

include '../connect.php';

$user_id = $_SESSION['user_id'];

// Get all products for current user
$sql = "SELECT * FROM products WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
</head>
<body>
    <h2>Manajemen Produk</h2>
    <p>Admin: <?= htmlspecialchars($_SESSION['name']) ?></p>
    <p>
        <a href="../dashboard.php">Dashboard</a> | 
        <a href="../authentication/profile.php">My Profile</a> | 
        <a href="../authentication/logout.php">Logout</a>
    </p>
    <hr>
    
    <p><a href="add_product.php"><strong>+ Tambah Produk Baru</strong></a></p>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Kode Produk</th>";
        echo "<th>Nama Produk</th>";
        echo "<th>Stok</th>";
        echo "<th>Harga</th>";
        echo "<th>Aksi</th>";
        echo "</tr>";
        
        $no = 1;
        while($row = $result->fetch_assoc()) {
            $stock_class = ($row['stock'] < 10) ? "style='color: red;'" : "";
            
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['product_code']) . "</td>";
            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
            echo "<td $stock_class>" . htmlspecialchars($row['stock']) . "</td>";
            echo "<td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
            echo "<td>";
            echo "<a href='edit_product.php?id=" . $row['id'] . "'>Edit</a> | ";
            echo "<a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p><em>Belum ada produk. Silakan tambahkan produk baru.</em></p>";
    }
    
    $conn->close();
    ?>
</body>
</html>

