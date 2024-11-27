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

<script>
    window.addEventListener('message', (event) => {
        if (event.data === 'post_deleted') {
            // Trigger a page reload
            window.location.reload();
        }
    });
</script>

<?php

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: ApplicantHome.php');
        exit();
    }

    if (isset($_SESSION['fname'])) { ?>
        <div class="account">Hello, HR <?php echo $_SESSION['fname']; ?></div>
<?php } else {
    header('Location: login.php');
    exit();  // Stop execution after redirecting to login
}


?>

<br>

<div class="main">
    <form action="core/handleForms.php" method="POST">
            <input type="text" name="search" placeholder="Search for a job post:">
            <input type="submit" value="Search" name="searchJobUserBtn">
            <button><a href="createPost.php" style="text-decoration: none; color: black;">Create A Post</a></button>
        </form>

    <h2>Job posts you created</h2><br>

    <iframe src="searchUserCreatedResults.php" frameborder="1" class="posts_frame"></iframe>

    <br><br><br><br><br>

    <form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for a job post:">
        <input type="submit" value="Search" name="searchJobBtn">
    </form>

    <h2>Jobs available</h2><br>

    <iframe src="searchResults.php" frameborder="1" class="posts_frame"></iframe>

    <form action="core/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>

</div>

</body>
</html>
