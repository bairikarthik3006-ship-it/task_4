<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// SETTINGS
$limit = 5;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
if ($page < 1) $page = 1;

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$offset = ($page - 1) * $limit;
$searchParam = "%$search%";

// FETCH POSTS
$stmt = $conn->prepare("SELECT * FROM posts 
    WHERE title LIKE ? OR content LIKE ?
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?");

$stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// DISPLAY POSTS
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars(substr($row['content'], 0, 120)) . "...";
        $id = $row['id'];

        // Format date
        $date = date("d M Y, h:i A", strtotime($row['created_at']));

        echo "
        <div class='card mb-3 shadow-sm'>
            <div class='card-body'>
                <h5 class='card-title'>$title</h5>
                <h6 class='card-subtitle mb-2 text-muted'>$date</h6>

                <p class='card-text'>$content</p>

                <a href='/blog-project/posts/view.php?id=$id' class='btn btn-primary btn-sm'>Read More</a>

                " . ((isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? "
    <a href='/blog-project/posts/edit.php?id=$id' class='btn btn-warning btn-sm ms-2'>Edit</a>

    <a href='/blog-project/posts/delete.php?id=$id' 
       class='btn btn-danger btn-sm ms-2'
       onclick=\"return confirm('Are you sure you want to delete this post?')\">
       Delete
    </a>
" : "") . "
            </div>
        </div>
        ";
    }
} else {
    echo "<p class='text-danger text-center mt-3'>No posts found 😢</p>";
}

// PAGINATION COUNT
$stmt2 = $conn->prepare("SELECT COUNT(*) as total FROM posts 
    WHERE title LIKE ? OR content LIKE ?");

$stmt2->bind_param("ss", $searchParam, $searchParam);
$stmt2->execute();

$total_result = $stmt2->get_result();
$total = $total_result->fetch_assoc()['total'];
$pages = ceil($total / $limit);

// PAGINATION BUTTONS

echo "<div class='text-center mt-3'>";

for ($i = 1; $i <= $pages; $i++) {
    echo "<button class='btn btn-outline-primary m-1 page-btn' data-page='$i'>$i</button>";
}

echo "</div>";
?>