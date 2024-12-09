<?php 
require_once 'core/handleForms.php';
require_once 'core/models.php';

if (!isset($_GET['postID'])) {
    echo "Post ID is missing.";
    exit();
}

// Grab postID from URL
$postID = $_GET['postID'];

// Get all posts by ID
$post = getPostById($pdo, $postID); 

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

<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;

    /* Add a background color with double gradients */
    background: linear-gradient(to bottom, #ffffff 80%, transparent),
                linear-gradient(to bottom, #FF6700 100%, rgba(255, 0, 0, 0) 110%);
    background-attachment: fixed;  /* Keeps the background fixed during scrolling */
    }
</style>

<div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
</div>

<br><br>

<div class="delete">
    <h3 style="color: #E55F00;">Are you sure you want to delete this job post?</h3>
    <div id="deletePostContainer">
        <h3 style="color: #E55F00;"><?php echo htmlspecialchars($post['post_title']); ?></h3>
        <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
        <h4 style="color: #E55F00;">Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>
    </div>
    
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>">
        <input type="hidden" name="fromIframe" value="1">
        <button type="submit" name="deletePostBtn" class="deletePostButton">Delete</button>
        <a href="HRHome.php" style="text-decoration: none;" class="returnButton">Cancel</a>
    </form>


</div>
</body>
</html>
