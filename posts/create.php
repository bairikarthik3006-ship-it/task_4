<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Only admin allowed
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: /blog-project/index.php");
    exit();
}

// ✅ Correct DB connection
require_once __DIR__ . '/../config/config.php';
?>

<h2>Add New Post</h2>

<form method="POST">
    Title: <input type="text" name="title" required><br><br>
    Content: <textarea name="content" required></textarea><br><br>
    <button type="submit" name="submit">Add Post</button>
</form>

<?php
if (isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // ✅ Prepared statement (secure)
    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Post added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error adding post!</p>";
    }
}
?>