<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Please login first!";
    exit();
}

include 'config.php';
?>

<h2>Add New Post</h2>

<form method="POST">
    Title: <input type="text" name="title" required><br><br>
    Content: <textarea name="content" required></textarea><br><br>
    <button name="submit">Add Post</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Post added successfully!";
    } else {
        echo "Error!";
    }
}
?>