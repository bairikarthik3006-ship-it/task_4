<?php include __DIR__ . '/includes/header.php'; ?>

<h2>All Posts</h2>

<!-- 🔍 SEARCH BOX -->
<input type="text" id="search" class="form-control mb-3" placeholder="🔍 Search posts...">
<!-- 📄 POSTS WILL LOAD HERE -->
<div id="post-container"></div>

<?php include __DIR__ . '/includes/folder.php'; ?>

<!-- ⚡ AJAX SCRIPT -->
<script>
function loadPosts(page = 1, search = "") {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/blog-project/posts/fetch_posts.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        document.getElementById("post-container").innerHTML = this.responseText;

        // Pagination buttons
        document.querySelectorAll(".page-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                loadPosts(this.dataset.page, search);
            });
        });
    };

    xhr.send("page=" + page + "&search=" + encodeURIComponent(search));
}

// 🔍 LIVE SEARCH
document.getElementById("search").addEventListener("keyup", function () {
    loadPosts(1, this.value);
});

// 🚀 LOAD FIRST TIME
loadPosts();
</script>