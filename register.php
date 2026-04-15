<?php
include "config.php";

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username) || empty($password)) {
        echo "All fields are required";
        exit();
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters";
        exit();
    }
}
?>

<h2>Register</h2>

<form method="POST" onsubmit="return validateForm()">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button name="submit">Register</button>
</form>

<br>
<a href="login.php">Already have account? Login</a>

<script>
function validateForm() {
    let email = document.forms[0]["email"].value;
    let password = document.forms[0]["password"].value;

    // Check empty
    if (email == "" || password == "") {
        alert("All fields are required");
        return false;
    }

    // Check email format
    if (!email.includes("@")) {
        alert("Invalid email");
        return false;
    }

    // Check password length
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }

    return true;
}
</script>