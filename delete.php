<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Please login first!";
    exit();
}

include 'config.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM posts WHERE id=$id");

header("Location: view.php");
?>