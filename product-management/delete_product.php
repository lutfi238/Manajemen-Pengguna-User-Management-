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

// Verify ownership before deleting
$check_sql = "SELECT product_name FROM products WHERE id = $product_id AND user_id = $user_id";
$result = $conn->query($check_sql);

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

// Delete product
$sql = "DELETE FROM products WHERE id = $product_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Success</title>";
    echo "<meta http-equiv='refresh' content='2;url=view_all_products.php'>";
    echo "</head>";
    echo "<body>";
    echo "<h2>Produk Berhasil Dihapus!</h2>";
    echo "<p>Produk <strong>" . htmlspecialchars($product['product_name']) . "</strong> telah berhasil dihapus.</p>";
    echo "<p>Redirecting to product list...</p>";
    echo "<p><a href='view_all_products.php'>Klik di sini</a> jika tidak redirect otomatis.</p>";
    echo "</body>";
    echo "</html>";
} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Terjadi kesalahan: " . $conn->error . "</p>";
    echo "<p><a href='view_all_products.php'>Back to Products</a></p>";
    echo "</body>";
    echo "</html>";
}

$conn->close();
?>

