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
    <title>Apply for a job</title>
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

   $postID = $_GET['postID'];
   $post = getPostById($pdo, $postID);

?>

<br>

<div class="main">

    <div class="post_container" style="width: 50%;">
        <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
        <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
        <h4>Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>
    </div>

    <br>

    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>">

        <label for="applicant_message">Why are you best fit for the role given?</label><br>
        <textarea name="applicant_message" id="applicant_message" cols="60" rows="10"></textarea>
        <br><br>
        
        <label for="resume">Attach your resume (PDF) here:</label><br>
        <input type="file" name="resume" id="resume">
        <br><br>

        <input type="submit" value="Submit" name="submitApplicationBtn">
    </form>

    <br>

    <button>
        <a href="ApplicantHome.php" style="text-decoration: none; color: black;">Cancel</a>
    </button>

</div>

</body>
</html>