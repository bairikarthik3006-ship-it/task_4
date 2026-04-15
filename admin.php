<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Only admin allowed
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied!";
    exit();
}
?>

<h2>Admin Dashboard</h2>
Welcome Admin: <?php echo $_SESSION['user']; ?>

<br><br>
<a href="view.php">Go to User Page</a><br>
<a href="logout.php">Logout</a>