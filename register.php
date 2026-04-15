<?php
include 'config.php';

$message = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($password)) {
        $message = "All fields are required!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } else {

        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $message = " Registration Successful! You can now login.";
        } else {
            $message = " Error: Username may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php if ($message != ""): ?>
    <p style="color:green;"><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST">

    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Register</button>

</form>

<br>
<a href="login.php">Already have account? Login</a>

</body>
</html>