<?php
// ✅ Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: /blog-project/auth/login.php");
    exit();
}

// ✅ Correct DB connection
require_once __DIR__ . '/../config/config.php';

// ✅ Check if ID exists
if (!isset($_GET['id'])) {
    echo "Invalid request!";
    exit();
}

$id = (int) $_GET['id'];

// ✅ Use prepared statement (secure)
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // ✅ Redirect after delete
    header("Location: /blog-project/index.php");
    exit();
} else {
    echo "Error deleting post!";
}
?>