<?php 

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';
require_once 'core/models.php';

// Fetch messages for the current logged-in user
$postID = $_GET['postID'];
$accountID = $_GET['accountID']; // AccountID of selected applicant
$currentFname = $_SESSION['fname'];
$currentLname = $_SESSION['lname'];

// Get receiver's fname and lname through the post
$post = getPostById($pdo, $postID);

$messages = getAllMessages($pdo, $postID, $accountID, $currentFname, $currentLname);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Messenger</title>
</head>
<body>
    
<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;

    /* Add a background color with double gradients */
    background: linear-gradient(to bottom, #ffffff 80%, transparent),
                linear-gradient(to bottom, #FF6700 100%, rgba(255, 0, 0, 0) 110%);
    height: 100%;  /* Make sure the body takes up the full viewport height */
    background-attachment: fixed;  /* Keeps the background fixed during scrolling */
}

</style>


<div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
</div>

<div class="messages">
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <h3><?php echo htmlspecialchars($message['senderFname']) . ' ' . htmlspecialchars($message['senderLname']); ?></h3>
            <p><?php echo htmlspecialchars($message['message']); ?></p>
            <span><?php echo htmlspecialchars($message['timestamp']); ?></span>
        </div>
    <?php endforeach; ?>
</div>

<br>

<form method="POST" action="core/handleForms.php" id="messageBarContainer">
        <input type="hidden" name="accountID" value="<?php echo $accountID; ?>">
        <input type="hidden" name="postID" value="<?php echo $postID; ?>">
        <textarea name="message" placeholder="Type your message here..." cols="60" rows="5" id="message_bar"></textarea><br>
        <button type="submit" name="sendMessage" id="messageButton">Send</button><br><br>
        <a href="checkApplications.php?postID=<?php echo htmlspecialchars($postID); ?>" style="text-decoration: none;" class="returnButton">Return</a>
</form>



</body>
</html>