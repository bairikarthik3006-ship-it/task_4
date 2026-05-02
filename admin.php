<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Only admin allowed
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /blog-project/index.php");
    exit();
}

require_once __DIR__ . '/config/config.php';

$postResult = $conn->query("SELECT COUNT(*) AS total_posts FROM posts");
$total_posts = $postResult->fetch_assoc()['total_posts'];

$userResult = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $userResult->fetch_assoc()['total_users'];

$commentResult = $conn->query("SHOW TABLES LIKE 'comments'");
if ($commentResult->num_rows > 0) {
    $commentCount = $conn->query("SELECT COUNT(*) AS total_comments FROM comments");
    $total_comments = $commentCount->fetch_assoc()['total_comments'];
} else {
    $total_comments = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #212529;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .topbar {
            background: #fff;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .card-box {
            border-radius: 12px;
        }
    </style>
</head>

<body>

<!-- 🔥 Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center mb-4">Admin Panel</h4>

    <a href="/blog-project/admin.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="/blog-project/posts/create.php">
        <i class="bi bi-plus-circle"></i> Create Post
    </a>

    <a href="/blog-project/index.php">
        <i class="bi bi-house"></i> View Site
    </a>

    <a href="/blog-project/auth/logout.php">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<!-- 📦 Main Content -->
<div class="content">

    <!-- Top Bar -->
    <div class="topbar shadow-sm">
        <h5 class="mb-0">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?> 👋</h5>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">

        <div class="col-md-4">
            <div class="card text-white bg-primary card-box p-3">
                <h5>Total Posts</h5>
                <h2><?php echo $total_posts; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success card-box p-3">
                <h5>Active Users</h5>
                <h2><?php echo $total_users; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger card-box p-3">
                <h5>Comments</h5>
                <h2><?php echo $total_comments; ?></h2>
            </div>
        </div>

    </div>

    <hr>

    <p class="text-muted">Use sidebar to manage your blog system.</p>

</div>

</body>
</html>