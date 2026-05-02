<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blog App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/blog-project/assets/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="/blog-project/index.php">My Blog</a>

    <div class="ms-auto d-flex align-items-center">

        <?php if (isset($_SESSION['user'])): ?>
            <span class="text-white me-3">
                Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>
            </span>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a class="btn btn-warning btn-sm me-2" href="/blog-project/admin.php">
                    Admin Panel
                </a>
            <?php endif; ?>

            <a class="btn btn-outline-light btn-sm" href="/blog-project/auth/logout.php">
                Logout
            </a>

        <?php else: ?>
            <a class="btn btn-outline-light btn-sm me-2" href="/blog-project/auth/login.php">
                Login
            </a>

            <a class="btn btn-light btn-sm" href="/blog-project/auth/register.php">
                Register
            </a>
        <?php endif; ?>

    </div>
</nav>

<div class="container mt-4">