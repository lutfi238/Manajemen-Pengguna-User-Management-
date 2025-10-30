<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name = $_POST['name'];
$email = $_POST['email'];
$psw = $_POST['psw'];
$confirm_psw = $_POST['confirm_psw'];

// Check if passwords match
if ($psw !== $confirm_psw) {
    echo "Passwords do not match. <a href='registration.php'>Back</a>";
    exit();
}

// Validate password length
if (strlen($psw) < 8) {
    echo "Password must be at least 8 characters long. <a href='registration.php'>Back</a>";
    exit();
}

include '../connect.php';

// Check if email already exists
$check_sql = "SELECT id FROM users WHERE email = '$email'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "<h2>Registration Failed</h2>";
    echo "<p>Email sudah digunakan. Silakan gunakan email lain.</p>";
    echo "<p><a href='registration.php'>Back</a> | <a href='../index.php'>Home</a></p>";
    $conn->close();
    exit();
}

// Generate activation token
$activation_token = bin2hex(random_bytes(32));

// Hash password
$hashed_psw = password_hash($psw, PASSWORD_DEFAULT);

// Auto-assign role as warehouse_admin
$role = 'warehouse_admin';

// Insert data user with activation token
$sql = "INSERT INTO users (name, email, password, role, is_active, activation_token)
VALUES ('$name', '$email', '$hashed_psw', '$role', 0, '$activation_token')";

if ($conn->query($sql) === TRUE) {
    // Send activation email
    $activation_link = "http://localhost/webpro_intro/tugas_2_UTS/password-management/activate.php?token=" . $activation_token;
    
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
        $mail->addAddress($email, $name);
        
        $mail->Subject = 'Aktivasi Akun - Warehouse Management System';
        $mail->Body = "Halo $name,\n\n";
        $mail->Body .= "Terima kasih telah mendaftar sebagai Admin Gudang.\n\n";
        $mail->Body .= "Silakan klik link berikut untuk mengaktifkan akun Anda:\n";
        $mail->Body .= "$activation_link\n\n";
        $mail->Body .= "Link ini berlaku untuk aktivasi akun Anda.\n\n";
        $mail->Body .= "Jika Anda tidak mendaftar, abaikan email ini.\n\n";
        $mail->Body .= "Salam,\nWarehouse Management System";
        
        $mail->send();
        $email_sent = true;
    } catch (Exception $e) {
        // Email sending failed, but registration succeeded
        $email_sent = false;
    }
    
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head><meta charset='UTF-8'><title>Registration Successful</title></head>";
    echo "<body>";
    echo "<h2>Registrasi Berhasil!</h2>";
    echo "<p>Akun Anda telah berhasil dibuat sebagai <strong>Admin Gudang</strong>.</p>";
    
    if ($email_sent) {
        echo "<p style='color: green;'>✓ Email aktivasi telah dikirim ke <strong>$email</strong></p>";
    } else {
        echo "<p style='color: orange;'>⚠ Email gagal dikirim. Gunakan link manual di bawah.</p>";
    }
    
    echo "<p><strong>Langkah selanjutnya:</strong></p>";
    echo "<ol>";
    echo "<li>Cek email Anda di <strong>$email</strong></li>";
    echo "<li>Klik link aktivasi yang dikirim ke email Anda</li>";
    echo "<li>Setelah aktivasi, <a href='../authentication/login.html'>Login</a> untuk mengakses sistem</li>";
    echo "</ol>";
    
    if (!$email_sent) {
        echo "<p><strong>Link Aktivasi Manual:</strong></p>";
        echo "<p><a href='$activation_link'>Klik di sini untuk aktivasi akun</a></p>";
    }
    
    echo "<p><a href='../index.php'>Back to Home</a></p>";
    echo "</body>";
    echo "</html>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br><a href='../index.php'>Back</a>";
}

$conn->close();
?>