<?php 
require_once 'core/handleForms.php';
require_once 'core/models.php';

if (!isset($_GET['postID'])) {
    echo "Post ID is missing.";
    exit();
}

$postID = $_GET['postID'];
$post = getPostById($pdo, $postID, $_SESSION['fname'], $_SESSION['lname']); 

if (!$post) {
    echo "Post not found or you are not authorized to delete this post.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Delete Post</title>
</head>
<body>

<div class="nav_bar">
        <span class="logo">
            <h1>FindHire</h1>
        </span>
</div>

<br><br>

<div class="delete">
    <h3 style="color: red;">Are you sure you want to delete this job post?</h3>
    <div class="post_container">
        <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
        <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
        <h4>Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>
    </div>
    
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>">
        <input type="hidden" name="fromIframe" value="1">
        <button type="submit" name="deletePostBtn">Delete</button>
        <button>
            <a href="HRHome.php" style="text-decoration: none; color: black;">Cancel</a>
        </button>
    </form>


</div>
</body>
</html>
