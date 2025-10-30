<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authentication/login.html');
    exit();
}

include '../connect.php';

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Ubah Password</h2>
    <a href="../authentication/profile.php">Back to My Profile</a>
    <form action="update_password.php" method="post">
        <table>
            <tr>
                <td>Email:</td>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
            <tr>
                <td>Current Password:</td>
                <td><input type="password" name="current_psw" required></td>
            </tr>
            <tr>
                <td>New Password:</td>
                <td><input type="password" name="new_psw" minlength="8" required></td>
            </tr>
            <tr>
                <td>Confirm New Password:</td>
                <td><input type="password" name="confirm_psw" minlength="8" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Change Password">
    </form>
</body>
</html>
