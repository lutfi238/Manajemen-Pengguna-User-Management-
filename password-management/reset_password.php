<?php
include '../connect.php';

// Check if this is GET request (show form) or POST request (process reset)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GET request - show password reset form
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    
    if (empty($token)) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Invalid Link</title></head>";
        echo "<body>";
        echo "<h2>Link Tidak Valid</h2>";
        echo "<p>Link reset password tidak valid.</p>";
        echo "<p><a href='../index.php'>Back to Home</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Verify token and check expiry
    $current_time = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expiry > '$current_time'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Token valid, show password reset form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Set New Password</title>
        </head>
        <body>
            <h2>Set Password Baru</h2>
            <form action="reset_password.php" method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <label for="new_psw">Password Baru:</label><br>
                <input type="password" name="new_psw" minlength="8" placeholder="Min 8 characters" required><br><br>
                <label for="confirm_psw">Konfirmasi Password:</label><br>
                <input type="password" name="confirm_psw" minlength="8" placeholder="Confirm password" required><br><br>
                <input type="submit" value="Reset Password">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Token Expired</title></head>";
        echo "<body>";
        echo "<h2>Link Kadaluarsa atau Tidak Valid</h2>";
        echo "<p>Link reset password sudah kadaluarsa atau tidak valid.</p>";
        echo "<p>Silakan minta link reset password baru.</p>";
        echo "<p><a href='reset_password.html'>Request New Link</a> | <a href='../index.php'>Home</a></p>";
        echo "</body>";
        echo "</html>";
    }
    
} else {
    // POST request - process password reset
    $token = $_POST['token'];
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
        echo "<p><a href='javascript:history.back()'>Back</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    if ($new_psw !== $confirm_psw) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Password tidak cocok.</p>";
        echo "<p><a href='javascript:history.back()'>Back</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Verify token again
    $current_time = date('Y-m-d H:i:s');
    $sql_check = "SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expiry > '$current_time'";
    $result = $conn->query($sql_check);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Hash new password
        $hashed_psw = password_hash($new_psw, PASSWORD_DEFAULT);
        
        // Update password and clear reset token
        $sql_update = "UPDATE users SET password='$hashed_psw', reset_token=NULL, reset_token_expiry=NULL WHERE reset_token='$token'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head><meta charset='UTF-8'><title>Password Reset Successful</title></head>";
            echo "<body>";
            echo "<h2>Password Berhasil Direset!</h2>";
            echo "<p>Password Anda telah berhasil diubah.</p>";
            echo "<p>Anda sekarang dapat login dengan password baru.</p>";
            echo "<p><a href='../authentication/login.html'>Login Sekarang</a> | <a href='../index.php'>Home</a></p>";
            echo "</body>";
            echo "</html>";
        } else {
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head><meta charset='UTF-8'><title>Error</title></head>";
            echo "<body>";
            echo "<h2>Error</h2>";
            echo "<p>Terjadi kesalahan saat mereset password.</p>";
            echo "<p><a href='../index.php'>Home</a></p>";
            echo "</body>";
            echo "</html>";
        }
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Token Invalid</title></head>";
        echo "<body>";
        echo "<h2>Token Tidak Valid</h2>";
        echo "<p>Token reset password tidak valid atau sudah kadaluarsa.</p>";
        echo "<p><a href='reset_password.html'>Request New Link</a> | <a href='../index.php'>Home</a></p>";
        echo "</body>";
        echo "</html>";
    }
}

$conn->close();
?>
