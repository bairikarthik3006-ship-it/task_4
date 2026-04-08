<?php
include 'db.php';

$limit = 5;

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$search = isset($_POST['search']) ? $_POST['search'] : '';

$offset = ($page - 1) * $limit;

// FETCH POSTS
$sql = "SELECT * FROM posts 
        WHERE title LIKE '%$search%' 
        OR content LIKE '%$search%' 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// DISPLAY POSTS
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
       echo "
<div class='card p-3 mb-3 shadow'>
    <h4>{$row['title']}</h4>
    <p>{$row['content']}</p>
    <small>{$row['created_at']}</small><br><br>

    <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
</div>";
    }
} else {
    echo "<p class='text-danger'>No posts found</p>";
}

// PAGINATION
$total_query = "SELECT COUNT(*) as total FROM posts 
                WHERE title LIKE '%$search%' 
                OR content LIKE '%$search%'";

$total_result = $conn->query($total_query);
$total = $total_result->fetch_assoc()['total'];

$pages = ceil($total / $limit);

// BUTTONS
echo "<div class='text-center'>";

for($i = 1; $i <= $pages; $i++){
    echo "<button class='btn btn-outline-primary m-1 page-btn' data-page='$i'>$i</button>";
}

echo "</div>";
?>