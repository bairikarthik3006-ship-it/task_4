```php
<?php
session_start();
require_once __DIR__ . '/../config/config.php';

$error = "";

if (isset($_POST['submit'])) {

    // Get and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validation
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

        // Prepare statement (SQL Injection protection)
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");

        if (!$stmt) {
            die("Query failed: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {

                // Store session data (VERY IMPORTANT for Task 5)
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
               if ($user['role'] === "admin") {
    header("Location: http://localhost:8080/blog-project/admin.php");
} else {
    header("Location: http://localhost:8080/blog-project/index.php");
}
exit();

            } else {
                $error = "Wrong password!";
            }

        } else {
            $error = "User not found!";
        }

        $stmt->close();
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Login Page</h2>

<?php if ($error != ""): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
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

<?php include __DIR__ . '/../includes/folder.php'; ?>

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
```
