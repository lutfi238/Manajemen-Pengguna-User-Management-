<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

include '../connect.php';

$user_id = $_SESSION['user_id'];
$current_psw = $_POST['current_psw'];
$new_psw = $_POST['new_psw'];
$confirm_psw = $_POST['confirm_psw'];

// Validate password length
if (strlen($new_psw) < 8) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Password harus minimal 8 karakter.</p>";
    echo "<p><a href='change_password.php'>Back</a></p>";
    echo "</body>";
    echo "</html>";
    exit();
}

// Check if new passwords match
if ($new_psw !== $confirm_psw) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Password baru tidak cocok.</p>";
    echo "<p><a href='change_password.php'>Back</a></p>";
    echo "</body>";
    echo "</html>";
    exit();
}

// Get current password from database
$sql = "SELECT password FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Verify current password
if (!password_verify($current_psw, $row['password'])) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Password saat ini salah.</p>";
    echo "<p><a href='change_password.php'>Back</a></p>";
    echo "</body>";
    echo "</html>";
    exit();
}

// Update to new password
$hashed_psw = password_hash($new_psw, PASSWORD_DEFAULT);
$sql_update = "UPDATE users SET password='$hashed_psw' WHERE id=$user_id";

if ($conn->query($sql_update) === TRUE) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Success</title></head>";
    echo "<body>";
    echo "<h2>Password Berhasil Diubah!</h2>";
    echo "<p>Password Anda telah berhasil diubah.</p>";
    echo "<p><a href='../authentication/profile.php'>Back to My Profile</a> | <a href='../dashboard.php'>Dashboard</a></p>";
    echo "</body>";
    echo "</html>";
} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Error</title></head>";
    echo "<body>";
    echo "<h2>Error</h2>";
    echo "<p>Terjadi kesalahan: " . $conn->error . "</p>";
    echo "<p><a href='change_password.php'>Back</a></p>";
    echo "</body>";
    echo "</html>";
}

$conn->close();
?>
