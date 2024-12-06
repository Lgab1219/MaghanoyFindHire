<?php 

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';
require_once 'core/models.php';

// Fetch postID based on the specific post
$postID = isset($_GET['postID']) ? $_GET['postID'] : null;

if (!$postID) {
    die("Error: postID not provided.");
}


// Get receiver's fname and lname through the post
$post = getPostById($pdo, $postID);

// Fetch all messages for the current user
$messages = getAllMessages($pdo, $postID, $_SESSION['fname'], $_SESSION['lname'], $post['fname'], $post['lname']);

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

<div class="nav_bar">
    <span class="logo">
        <h1>FindHire</h1>
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

<form method="POST" action="core/handleForms.php">
        <input type="hidden" name="postID" value="<?php echo $postID; ?>">
        <textarea name="message" placeholder="Type your message here..." cols="60" rows="5"></textarea>
        <button type="submit" name="sendMessage">Send</button>
</form>

<br>

<button>
    <a href="ApplicantHome.php" style="text-decoration: none; color: black;">Return</a>
</button>

</body>
</html>