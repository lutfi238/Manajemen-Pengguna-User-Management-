<?php
include '../connect.php';

// Get token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Invalid Activation Link</title></head>";
    echo "<body>";
    echo "<h2>Link Aktivasi Tidak Valid</h2>";
    echo "<p>Link aktivasi yang Anda gunakan tidak valid atau sudah kadaluarsa.</p>";
    echo "<p><a href='../index.php'>Back to Home</a></p>";
    echo "</body>";
    echo "</html>";
    $conn->close();
    exit();
}

// Check if token exists and account is not activated yet
$sql = "SELECT * FROM users WHERE activation_token = '$token' AND is_active = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Activate the account
    $sql_update = "UPDATE users SET is_active = 1, activation_token = NULL WHERE activation_token = '$token'";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Account Activated</title></head>";
        echo "<body>";
        echo "<h2>Aktivasi Berhasil!</h2>";
        echo "<p>Akun Anda telah berhasil diaktifkan, <strong>" . htmlspecialchars($row['name']) . "</strong>.</p>";
        echo "<p>Anda sekarang dapat login ke sistem sebagai <strong>Admin Gudang</strong>.</p>";
        echo "<p><a href='../authentication/login.html'>Login Sekarang</a> | <a href='../index.php'>Home</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Activation Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Terjadi kesalahan saat mengaktifkan akun: " . $conn->error . "</p>";
        echo "<p><a href='../index.php'>Back to Home</a></p>";
        echo "</body>";
        echo "</html>";
    }
} else {
    // Check if account is already activated
    $sql_check = "SELECT * FROM users WHERE activation_token = '$token' AND is_active = 1";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Already Activated</title></head>";
        echo "<body>";
        echo "<h2>Akun Sudah Aktif</h2>";
        echo "<p>Akun ini sudah diaktifkan sebelumnya.</p>";
        echo "<p><a href='../authentication/login.html'>Login</a> | <a href='../index.php'>Home</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Invalid Token</title></head>";
        echo "<body>";
        echo "<h2>Token Tidak Valid</h2>";
        echo "<p>Token aktivasi tidak ditemukan atau sudah tidak valid.</p>";
        echo "<p><a href='../index.php'>Back to Home</a></p>";
        echo "</body>";
        echo "</html>";
    }
}

$conn->close();
?>