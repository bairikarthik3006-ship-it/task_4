<?php
session_start();
include 'config.php';

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $user = $result->fetch_assoc();

    if(password_verify($password, $user['password'])){
        $_SESSION['user'] = $username;
        header("Location: view.php");
    } else {
        echo "<script>alert('Wrong password');</script>";
    }
} else {
    echo "<script>alert('User not found');</script>";
}
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: test.php");
            exit();
        } else {
            echo "Wrong Password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<h2>Login</h2>

<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button name="submit">Login</button>
</form>

<br>
<a href="register.php">Don't have account? Register</a>