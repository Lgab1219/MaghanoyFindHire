<?php 

require_once 'core/handleForms.php';
require_once 'core/models.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: ApplicantHome.php');
        exit();
    }

    if(isset($_SESSION['fname'])) { ?>
        <div class="message">Hello, HR <?php echo $_SESSION['fname']; ?></div>
<?php } else {
    header('Location: login.php');
}
    $searchUserResults = isset($_SESSION['searchUserResults']) ? $_SESSION['searchUserResults'] : [];
    $postsUser = empty($searchUserResults) ? getAllPostsOfUser($pdo, $_SESSION['fname'], $_SESSION['lname']) : $searchUserResults;

    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
    $posts = empty($searchResults) ? getAllPosts($pdo) : $searchResults;

?>
<br>
<form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for a job post:">
        <input type="submit" value="Search" name="searchJobUserBtn">
        <button><a href="createPost.php" style="text-decoration: none; color: black;">Create A Post</a></button>
    </form>

<h2>Job posts you created</h2><br>

<?php foreach($postsUser as $postUser) : ?>

    <div class="post_container">
        <h3><?php echo $postUser['post_title']; ?></h3>
        <p><?php echo $postUser['post_desc']; ?></p>
        <h4>Posted by: <?php echo $postUser['fname'] . $postUser['lname']; ?></h4>
    </div>

    <br>

<?php endforeach; ?>
<br>

    <form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for a job post:">
        <input type="submit" value="Search" name="searchJobBtn">
    </form>

<h2>Jobs available</h2><br>

<?php foreach($posts as $post) : ?>

    <div class="post_container">
        <h3><?php echo $post['post_title']; ?></h3>
        <p><?php echo $post['post_desc']; ?></p>
        <h4>Posted by: <?php echo $post['fname'] . $post['lname']; ?></h4>
    </div>

    <br>

<?php endforeach; ?>

<form action="core/logout.php" method="POST">
    <button type="submit">Logout</button>
</form>

</body>
</html>