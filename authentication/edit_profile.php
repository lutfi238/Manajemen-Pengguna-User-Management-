<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../connect.php';
    
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    
    // Verify current password
    $sql_check = "SELECT password FROM users WHERE id = $user_id";
    $result = $conn->query($sql_check);
    $row = $result->fetch_assoc();
    
    if (!password_verify($current_password, $row['password'])) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Password saat ini salah.</p>";
        echo "<p><a href='edit_profile.php'>Back</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Check if email is already used by another user
    $sql_email_check = "SELECT id FROM users WHERE email = '$email' AND id != $user_id";
    $result_email = $conn->query($sql_email_check);
    
    if ($result_email->num_rows > 0) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Email sudah digunakan oleh user lain.</p>";
        echo "<p><a href='edit_profile.php'>Back</a></p>";
        echo "</body>";
        echo "</html>";
        $conn->close();
        exit();
    }
    
    // Update profile
    $sql_update = "UPDATE users SET name = '$name', email = '$email' WHERE id = $user_id";
    
    if ($conn->query($sql_update) === TRUE) {
        // Update session
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Success</title></head>";
        echo "<body>";
        echo "<h2>Profil Berhasil Diupdate!</h2>";
        echo "<p>Profil Anda telah berhasil diperbarui.</p>";
        echo "<p><a href='profile.php'>Lihat Profil</a> | <a href='../dashboard.php'>Dashboard</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head><meta charset='UTF-8'><title>Error</title></head>";
        echo "<body>";
        echo "<h2>Error</h2>";
        echo "<p>Terjadi kesalahan: " . $conn->error . "</p>";
        echo "<p><a href='edit_profile.php'>Back</a></p>";
        echo "</body>";
        echo "</html>";
    }
    
    $conn->close();
    exit();
}

// Get current user data
include '../connect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profil</h2>
    <a href="profile.php">Back to Profile</a>
    <br><br>
    
    <form action="edit_profile.php" method="post">
        <table>
            <tr>
                <td>Nama:</td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
            </tr>
            <tr>
                <td>Role:</td>
                <td><strong><?= htmlspecialchars($user['role']) ?></strong> (tidak dapat diubah)</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td>Password Saat Ini:</td>
                <td><input type="password" name="current_password" required></td>
            </tr>
            <tr>
                <td colspan="2"><em>Masukkan password saat ini untuk verifikasi.</em></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Update Profil">
    </form>
</body>
</html>

