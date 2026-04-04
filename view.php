<?php
session_start();
include 'config.php';

// Search logic
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE title LIKE '%$search%'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM posts");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        .top-bar {
            margin: 20px;
        }
        .top-bar a {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .search-box {
            margin: 20px;
        }
        input {
            padding: 8px;
            width: 200px;
        }
        button {
            padding: 8px 12px;
            background: black;
            color: white;
            border: none;
        }
        .post {
            background: white;
            padding: 15px;
            margin: 20px auto;
            width: 50%;
            box-shadow: 0 0 10px gray;
            border-radius: 10px;
        }
        .actions a {
            text-decoration: none;
            margin: 5px;
            padding: 5px 10px;
            background: black;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h1>My Blog</h1>

<div style="margin:20px;">
<?php
if (isset($_SESSION['user'])) {
    echo "Welcome, <b>" . $_SESSION['user'] . "</b> ";
    echo "| <a href='logout.php'>Logout</a>";
} else {
    echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
}
?>
</div>

<!-- ✅ Create Post Button -->
<div class="top-bar">
    <a href="create.php">➕ Create Post</a>
</div>

<!-- 🔍 Search Box -->
<div class="search-box">
    <form method="GET">
        <input type="text" name="search" placeholder="Search posts...">
        <button>Search</button>
    </form>
</div>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='post'>";
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<small>" . $row['created_at'] . "</small><br><br>";

        echo "<div class='actions'>";
        echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a>";
        echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
        echo "</div>";

        echo "</div>";
    }
} else {
    echo "<p>No posts found</p>";
}
?>

</body>
</html>