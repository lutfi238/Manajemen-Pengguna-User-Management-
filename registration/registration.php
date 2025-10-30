<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Warehouse Admin</title>
</head>
<body>
    <h2>Register as Warehouse Admin</h2>
    <a href="../index.php">Back</a>
    <form action="create_account.php" method="post">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" placeholder="Your full name" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" placeholder="Your email address" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="psw" minlength="8" placeholder="Min 8 characters" required></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="password" name="confirm_psw" minlength="8" placeholder="Confirm password" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>