<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

include '../connect.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Get product and verify ownership
$sql = "SELECT * FROM products WHERE id = $product_id AND user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Produk tidak ditemukan atau Anda tidak memiliki akses.</p>";
    echo "<p><a href='view_all_products.php'>Back to Products</a></p>";
    echo "</body>";
    echo "</html>";
    $conn->close();
    exit();
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h2>Edit Produk</h2>
    <a href="view_all_products.php">Back to Products</a>
    <br><br>
    
    <form action="update_product.php" method="post">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        
        <table>
            <tr>
                <td>Kode Produk:</td>
                <td><input type="text" name="product_code" value="<?= htmlspecialchars($product['product_code']) ?>" required></td>
            </tr>
            <tr>
                <td>Nama Produk:</td>
                <td><input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required></td>
            </tr>
            <tr>
                <td>Deskripsi:</td>
                <td><textarea name="description" rows="4" cols="30"><?= htmlspecialchars($product['description']) ?></textarea></td>
            </tr>
            <tr>
                <td>Stok:</td>
                <td><input type="number" name="stock" value="<?= $product['stock'] ?>" min="0" required></td>
            </tr>
            <tr>
                <td>Harga (Rp):</td>
                <td><input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Update Produk">
    </form>
</body>
</html>
<?php
$conn->close();
?>

