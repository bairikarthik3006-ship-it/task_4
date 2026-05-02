<?php

// ✅ Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Check login first
if (!isset($_SESSION['user'])) {
    header("Location: /blog-project/auth/login.php");
    exit();
}

// 🔐 Check admin role
if ($_SESSION['role'] !== 'admin') {
    header("Location: /blog-project/index.php");
    exit();
}

require_once __DIR__ . '/../config/config.php';

// 🔐 Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid post ID!";
    exit();
}

$id = $_GET['id'];

// 🔐 Prepared statement (SELECT)
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "Post not found!";
    exit();
}

// ✅ Update logic
$message = "";

if (isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // 🔐 Validation
    if (empty($title) || empty($content)) {
        $message = "All fields are required!";
    } else {

        // 🔐 Prepared statement (UPDATE)
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
            $message = " Post updated successfully!";
        } else {
            $message = " Update failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<?php if ($message != "") echo "<p>$message</p>"; ?>

<form method="POST">

    Title:
    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>"><br><br>

    Content:
    <textarea name="content"><?php echo htmlspecialchars($row['content']); ?></textarea><br><br>

    <button name="update">Update</button>

</form>

</body>
</html>