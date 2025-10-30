<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

include '../connect.php';

$product_id = intval($_POST['id']);
$product_code = $_POST['product_code'];
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$stock = $_POST['stock'];
$price = $_POST['price'];
$user_id = $_SESSION['user_id'];

// Verify ownership
$check_sql = "SELECT id FROM products WHERE id = $product_id AND user_id = $user_id";
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

// Check if product code is unique (excluding current product)
$check_code = "SELECT id FROM products WHERE product_code = '$product_code' AND id != $product_id";
$result_code = $conn->query($check_code);

if ($result_code->num_rows > 0) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Kode produk sudah digunakan oleh produk lain.</p>";
    echo "<p><a href='edit_product.php?id=$product_id'>Back</a></p>";
    echo "</body>";
    echo "</html>";
    $conn->close();
    exit();
}

// Update product
$sql = "UPDATE products SET 
        product_code = '$product_code',
        product_name = '$product_name',
        description = '$description',
        stock = $stock,
        price = $price
        WHERE id = $product_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Success</title></head>";
    echo "<body>";
    echo "<h2>Produk Berhasil Diupdate!</h2>";
    echo "<p>Produk <strong>" . htmlspecialchars($product_name) . "</strong> telah berhasil diupdate.</p>";
    echo "<p><a href='view_all_products.php'>Lihat Semua Produk</a></p>";
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

