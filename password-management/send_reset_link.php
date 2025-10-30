<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../connect.php';

$email = $_POST['email'];

// Check if account exists
$sql_check = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Generate reset token
    $reset_token = bin2hex(random_bytes(32));
    
    // Set token expiry to 1 hour from now
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Store token and expiry in database
    $sql_update = "UPDATE users SET reset_token='$reset_token', reset_token_expiry='$expiry' WHERE email='$email'";
    
    if ($conn->query($sql_update) === TRUE) {
        // Create reset link
        $reset_link = "http://localhost/webpro_intro/tugas_2_UTS/password-management/reset_password.php?token=" . $reset_token;
        
        // Send email with PHPMailer
        require '../configuration/vendor/autoload.php';
        $emailConfig = require '../configuration/email_config.php';
        
        $mail = new PHPMailer(true);
        $email_sent = false;
        
        try {
            $mail->isSMTP();
            $mail->Host = $emailConfig['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $emailConfig['smtp_username'];
            $mail->Password = $emailConfig['smtp_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $emailConfig['smtp_port'];
            
            $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
            $mail->addAddress($email, $row['name']);
            
            $mail->Subject = 'Reset Password - Warehouse Management System';
            $mail->Body = "Halo " . $row['name'] . ",\n\n";
            $mail->Body .= "Kami menerima permintaan untuk mereset password akun Anda.\n\n";
            $mail->Body .= "Silakan klik link berikut untuk mereset password Anda:\n";
            $mail->Body .= "$reset_link\n\n";
            $mail->Body .= "Link ini akan kadaluarsa dalam 1 jam.\n\n";
            $mail->Body .= "Jika Anda tidak meminta reset password, abaikan email ini.\n\n";
            $mail->Body .= "Salam,\nWarehouse Management System";
            
            $mail->send();
            $email_sent = true;
        } catch (Exception $e) {
            // Email sending failed, but token is created
            $email_sent = false;
        }
        
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Reset Password Link Sent</title></head>";
        echo "<body>";
        echo "<h2>Link Reset Password</h2>";
        
        if ($email_sent) {
            echo "<p style='color: green;'>✓ Link reset password telah dikirim ke <strong>$email</strong></p>";
        } else {
            echo "<p style='color: orange;'>⚠ Email gagal dikirim. Gunakan link manual di bawah.</p>";
        }
        
        echo "<p>Silakan cek email Anda dan klik link yang diberikan untuk mereset password.</p>";
        echo "<p>Link akan kadaluarsa dalam <strong>1 jam</strong>.</p>";
        
        if (!$email_sent) {
            echo "<p><strong>Link Reset Password Manual:</strong></p>";
            echo "<p><a href='$reset_link'>Klik di sini untuk reset password</a></p>";
        }
        
        echo "<p><a href='../index.php'>Back to Home</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Terjadi kesalahan. Silakan coba lagi nanti.</p>";
        echo "<p><a href='reset_password.html'>Back</a></p>";
        echo "</body>";
        echo "</html>";
    }
} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Account Not Found</title></head>";
    echo "<body>";
    echo "<h2>Email Tidak Ditemukan</h2>";
    echo "<p>Email yang Anda masukkan tidak terdaftar dalam sistem.</p>";
    echo "<p><a href='reset_password.html'>Back</a> | <a href='../index.php'>Home</a></p>";
    echo "</body>";
    echo "</html>";
}

$conn->close();
?>

