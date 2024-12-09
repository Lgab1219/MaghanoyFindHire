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


<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;

    /* Add a background color with double gradients */
    background: linear-gradient(to bottom, #ffffff 80%, transparent),
                linear-gradient(to bottom, #FF6700 100%, rgba(255, 0, 0, 0) 110%);
    
    height: 100%;
}

</style>

<div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
</div>

<?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: HRHome.php');
    exit();
    }

    if(isset($_SESSION['fname'])) { ?>
        <div class="account_container">
            <div class="account"><h3 style="color: white;">Hello, <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h3></div>
            <form action="core/logout.php" method="POST" style="margin: -8em 0 0 -2em;">
                <button type="submit" class="logout_button">Logout</button>
            </form>
        </div>
<?php } else {
    header('Location: login.php');
}

   $postID = $_GET['postID'];
   $post = getPostById($pdo, $postID);

?>

<br>

<div id="applicationFormContainer">

    <div class="post_container" style="width: 50%;">
        <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
        <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
        <h4>Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>
    </div>

    <br>

    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data" id="applicationForm">
        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>">

        <label for="applicant_message">Why are you best fit for the role given?</label><br>
        <textarea name="applicant_message" id="applicant_message" cols="60" rows="10"></textarea>
        <br><br>
        
        <label for="resume">Attach your resume (PDF) here:</label><br>
        <input type="file" name="resume" id="resume">
        <br><br>

        <input type="submit" value="Submit" name="submitApplicationBtn" id="applicantSubmitButton"><br><br>
        <a href="ApplicantHome.php" style="text-decoration: none;" class="returnButton">Cancel</a>
    </form>

</div>

</body>
</html>