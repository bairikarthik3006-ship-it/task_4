<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Single clean session check
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Advanced Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">🚀 Blog System</span>

    <div>
        <span class="text-white me-3">
            Welcome, <?php echo $_SESSION['user']; ?>
        </span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container mt-5">

    <h2 class="text-center mb-4">🚀 Advanced Blog System</h2>

    <!-- SEARCH BAR -->
    <input type="text" id="search" class="form-control mb-3" placeholder="Search posts...">

    <!-- RESULTS -->
    <div id="postData"></div>

</div>

<script>

// LOAD DATA FUNCTION
function loadData(page = 1, search = '') {
    $.post("fetch_posts.php", {
        page: page,
        search: search
    }, function(data){
        $("#postData").html(data);
    });
}

// INITIAL LOAD
loadData();

// SEARCH EVENT
$("#search").keyup(function(){
    let search = $(this).val();
    loadData(1, search);
});

// PAGINATION CLICK
$(document).on("click", ".page-btn", function(){
    let page = $(this).data("page");
    let search = $("#search").val();
    loadData(page, search);
});

</script>

</body>
</html>