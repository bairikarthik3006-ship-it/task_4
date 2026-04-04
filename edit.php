<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Please login first!";
    exit();
}

include 'config.php';

$id = $_GET['id'];

// Get old data
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">
    Title: <input type="text" name="title" value="<?php echo $row['title']; ?>"><br><br>
    Content: <textarea name="content"><?php echo $row['content']; ?></textarea><br><br>
    <button name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query($conn, "UPDATE posts SET title='$title', content='$content' WHERE id=$id");

    echo "Post updated successfully!";
}
?>

</body>
</html>