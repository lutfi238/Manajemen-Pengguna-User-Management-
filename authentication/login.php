<?php
session_start();
include '../connect.php';

$email = $_POST['usr'];
$psw = $_POST['psw'];

// Check if user exists
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Check if account is active
    if ($row['is_active'] != 1) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Account Not Activated</title></head>";
        echo "<body>";
        echo "<h2>Akun Belum Diaktifkan</h2>";
        echo "<p>Akun Anda belum diaktifkan. Silakan cek email untuk link aktivasi.</p>";
        echo "<p><a href='login.html'>Back to Login</a> | <a href='../index.php'>Home</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Verify password
    if (password_verify($psw, $row['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        
        // Redirect to dashboard
        header('Location: ../dashboard.php');
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Login Failed</title></head>";
        echo "<body>";
        echo "<h2>Login Gagal</h2>";
        echo "<p>Password yang Anda masukkan salah.</p>";
        echo "<p><a href='login.html'>Try Again</a> | <a href='../password-management/reset_password.html'>Lupa Password?</a></p>";
        echo "</body>";
        echo "</html>";
    }
} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>User Not Found</title></head>";
    echo "<body>";
    echo "<h2>User Tidak Ditemukan</h2>";
    echo "<p>Email tidak terdaftar dalam sistem.</p>";
    echo "<p><a href='login.html'>Try Again</a> | <a href='../registration/registration.php'>Register</a></p>";
    echo "</body>";
    echo "</html>";
}

$conn->close();
?>