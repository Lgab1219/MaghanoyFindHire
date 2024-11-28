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
    <title>Home</title>
</head>
<body>

<div class="nav_bar">
        <span class="logo">
            <h1>FindHire</h1>
        </span>
</div>

<?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: HRHome.php');
    exit();
    }

    if(isset($_SESSION['fname'])) { ?>
        <div class="account">Hello, Applicant <?php echo $_SESSION['fname']; ?></div>
<?php } else {
    header('Location: login.php');
    }

    if (isset($_SESSION['message'])) : ?>
        <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif;

    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
    $posts = empty($searchResults) ? getAllPosts($pdo) : $searchResults;

?>

<br>

<div class="main">
    <form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for a job post:">
        <input type="submit" value="Search" name="searchJobBtn">
    </form>

    <h2>Jobs available</h2><br>

    <?php foreach($posts as $post) : ?>

    <div class="post_container" style="width: 50%;">
        <h3><?php echo $post['post_title']; ?></h3>
        <p><?php echo $post['post_desc']; ?></p>
        <h4>Posted by: <?php echo $post['fname'] . $post['lname']; ?></h4>
        <button>
        <a href="ApplicationForm.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none; color: black;">Add an application</a>
        </button>
    </div>

    <br>

<?php endforeach; ?>

    <form action="core/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</div>

</body>
</html>