<?php 

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="nav_bar">
            <span class="logo">
                <h1>FindHire</h1>
            </span>
    </div>

<br><br>

    <div class="form">
        <?php 
            if(isset($_SESSION['message'])) { ?>
                <div class="message"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); }
        ?>
        <h2>Write a job post</h2>
        <form action="core/handleForms.php" method="POST">
            <label for="post_title">Job Title</label>
            <input type="text" name="post_title" id="post_title">
            <br><br>

            <label for="post_desc">Job Description</label><br>
            <textarea name="post_desc" id="post_desc" cols="60" rows="10"></textarea>
            <br><br>

            <input type="submit" value="Post" name="createPostBtn">
        </form><br><br>
        <button><a href="HRHome.php" style="text-decoration: none; color: black;">Cancel</a></button>
    </div>
</body>
</html>