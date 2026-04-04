<?php
include "config.php";

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if(mysqli_query($conn, $sql)) {
        echo "User Registered Successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Register</h2>

<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button name="submit">Register</button>
</form>

<br>
<a href="login.php">Already have account? Login</a>