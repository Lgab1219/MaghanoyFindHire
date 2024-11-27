<?php 

require_once 'core/handleForms.php';
require_once 'core/models.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>

<?php

    $searchUserResults = isset($_SESSION['searchUserResults']) ? $_SESSION['searchUserResults'] : [];
    $postsUser = empty($searchUserResults) ? getAllPostsOfUser($pdo, $_SESSION['fname'], $_SESSION['lname']) : $searchUserResults;

?>


<?php foreach($postsUser as $post) : ?>

<div class="post_container">
    <h3><?php echo $post['post_title']; ?></h3>
    <p><?php echo $post['post_desc']; ?></p>
    <h4>Posted by: <?php echo $post['fname'] . $post['lname']; ?></h4>
    <button>
    <a href="deletePost.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none; color: black;">Delete</a>
    </button>
</div>

<br>

<?php endforeach; ?>

<br>
</body>
</html>