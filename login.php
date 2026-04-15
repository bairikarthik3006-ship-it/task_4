<?php
session_start();
include 'config.php';

$error = "";

// ✅ Server-side validation FIRST (Task 4 requirement)
if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($password)) {
        $error = "All fields are required!";
    }

    
    elseif (strlen($username) < 3) {
        $error = "Username must be at least 3 characters!";
    }

    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    }

    else {

        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            
            if (password_verify($password, $user['password'])) {

                
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // 🔐 Role-based access control
                if ($user['role'] === "admin") {
                    header("Location: admin.php");
                } else {
                    header("Location: view.php");
                }
                exit();

            } else {
                $error = "Wrong password!";
            }

        } else {
            $error = "User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Task 4</title>
</head>
<body>

<h2>Login Page</h2>

<?php if ($error != ""): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" onsubmit="return validateForm()">

    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">Login</button>
</form>

<br>
<a href="register.php">Don't have an account? Register</a>

<script>
function validateForm() {

    let username = document.forms[0]["username"].value.trim();
    let password = document.forms[0]["password"].value.trim();

    
    if (username === "" || password === "") {
        alert("All fields are required");
        return false;
    }

    
    if (username.length < 3) {
        alert("Username must be at least 3 characters");
        return false;
    }

    
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }

    return true;
}
</script>

</body>
</html>