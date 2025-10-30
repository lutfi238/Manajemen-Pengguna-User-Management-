<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../connect.php';
    
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];
    
    // Check if product code already exists
    $check_sql = "SELECT id FROM products WHERE product_code = '$product_code'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Kode produk sudah digunakan. Gunakan kode produk lain.</p>";
        echo "<p><a href='add_product.php'>Back</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Insert product
    $sql = "INSERT INTO products (product_code, product_name, description, stock, price, user_id) 
            VALUES ('$product_code', '$product_name', '$description', $stock, $price, $user_id)";
    
    if ($conn->query($sql) === TRUE) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Success</title></head>";
        echo "<body>";
        echo "<h2>Produk Berhasil Ditambahkan!</h2>";
        echo "<p>Produk <strong>" . htmlspecialchars($product_name) . "</strong> telah berhasil ditambahkan.</p>";
        echo "<p><a href='view_all_products.php'>Lihat Semua Produk</a> | <a href='add_product.php'>Tambah Produk Lagi</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Terjadi kesalahan: " . $conn->error . "</p>";
        echo "<p><a href='add_product.php'>Back</a></p>";
        echo "</body>";
        echo "</html>";
    }
    
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <a href="view_all_products.php">Back to Products</a>
    <br><br>
    
    <form action="add_product.php" method="post">
        <table>
            <tr>
                <td>Kode Produk:</td>
                <td><input type="text" name="product_code" placeholder="e.g., BRG001" required></td>
            </tr>
            <tr>
                <td>Nama Produk:</td>
                <td><input type="text" name="product_name" placeholder="e.g., Laptop Dell" required></td>
            </tr>
            <tr>
                <td>Deskripsi:</td>
                <td><textarea name="description" rows="4" cols="30" placeholder="Deskripsi produk (opsional)"></textarea></td>
            </tr>
            <tr>
                <td>Stok:</td>
                <td><input type="number" name="stock" value="0" min="0" required></td>
            </tr>
            <tr>
                <td>Harga (Rp):</td>
                <td><input type="number" name="price" step="0.01" placeholder="e.g., 5000000" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Tambah Produk">
    </form>
</body>
</html>

