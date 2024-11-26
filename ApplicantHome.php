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
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: HRHome.php');
    exit();
    }

    if(isset($_SESSION['fname'])) { ?>
        <div>Hello, Applicant <?php echo $_SESSION['fname']; ?></div>
<?php } else {
    header('Location: login.php');
}

    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
    $posts = empty($searchResults) ? getAllPosts($pdo) : $searchResults;

?>
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
<br>

<form action="core/logout.php" method="POST">
    <button type="submit">Logout</button>
</form>
</body>
</html>