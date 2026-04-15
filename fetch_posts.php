<?php
include 'db.php';

$limit = 5;

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
if($page < 1) $page = 1;
$search = isset($_POST['search']) ? $_POST['search'] : '';

$offset = ($page - 1) * $limit;

// Prepare search parameter
$searchParam = "%$search%";

$stmt = $conn->prepare("SELECT * FROM posts 
        WHERE title LIKE ? 
        OR content LIKE ? 
        ORDER BY created_at DESC 
        LIMIT ? OFFSET ?");

// Bind parameters
$stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);

// Execute
$stmt->execute();

$result = $stmt->get_result();

// DISPLAY POSTS
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
       echo "
<div class='card p-3 mb-3 shadow'>
    <h4>" . htmlspecialchars($row['title']) . "</h4>
<p>" . htmlspecialchars($row['content']) . "</p>
    <small>{$row['created_at']}</small><br><br>

    <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
</div>";
    }
} else {
    echo "<p class='text-danger'>No posts found</p>";
}

// PAGINATION
$searchParam = "%$search%";

$stmt2 = $conn->prepare("SELECT COUNT(*) as total FROM posts 
                WHERE title LIKE ? 
                OR content LIKE ?");

$stmt2->bind_param("ss", $searchParam, $searchParam);
$stmt2->execute();

$total_result = $stmt2->get_result();
$total = $total_result->fetch_assoc()['total'];

$pages = ceil($total / $limit);

// BUTTONS
echo "<div class='text-center'>";

for($i = 1; $i <= $pages; $i++){
    echo "<button class='btn btn-outline-primary m-1 page-btn' data-page='$i'>$i</button>";
}

echo "</div>";
?>