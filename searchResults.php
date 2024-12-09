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

<style>
body {
    background: #ffffff; /* Override any inherited styles */
    margin: 0;
}
</style>


<?php

    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
    $posts = empty($searchResults) ? getAllPosts($pdo) : $searchResults;

?>

<?php foreach($posts as $post) : ?>

<div class="post_container">
    <h3 style="color: #004E98;"><?php echo $post['post_title']; ?></h3>
    <p><?php echo $post['post_desc']; ?></p>
    <h4 style="color: #ff822f;">Posted by: <?php echo $post['fname'] . $post['lname']; ?></h4>
</div>

<br>

<?php endforeach; ?>
<br>
</body>
</html>