<?php

require_once 'core/dbConfig.php';
require_once 'core/handleForms.php';
require_once 'core/models.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Check Applications</title>
</head>

<body>

<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;

    /* Add a background color with double gradients */
    background: linear-gradient(to bottom, #ffffff 80%, transparent),
                linear-gradient(to bottom, #FF6700 100%, rgba(255, 0, 0, 0) 110%);
    height: 100vh;  /* Make sure the body takes up the full viewport height */
    background-attachment: fixed;  /* Keeps the background fixed during scrolling */
}

</style>

<div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
</div>

<?php

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: ApplicantHome.php');
    exit();
    }

    if (isset($_SESSION['fname'])) { ?>
      <div class="account_container">
          <div class="account"><h3 style="color: white;">Hello, <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h3></div>
          <form action="core/logout.php" method="POST" style="margin: -8em 0 0 -2em;">
              <button type="submit" class="logout_button">Logout</button>
          </form>
      </div>
    <?php } else {
        header('Location: login.php');
    exit();
}

// Check if postID is provided in the URL

    if (!isset($_GET['postID'])) {
        echo "Error: No job post selected.";
    exit();
    }

    $postID = $_GET['postID'];
    $postTitle = getPostById($pdo, $postID);
    $applications = getApplicationsByPostID($pdo, $postID);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $applicationID = $_POST['applicationID'];
        $action = $_POST['action'];
        
        if ($action === 'accept') {
        acceptApplication($pdo, $applicationID);
    }   
        elseif ($action === 'reject') {
        rejectApplication($pdo, $applicationID);
    }

    // Refresh the page to update the application list
    header("Location: checkApplications.php?postID=" . htmlspecialchars($postID));
    exit();
  }



  // Fetch all accepted applications
  $acceptedApplications = getAcceptedApplicationsByPostID($pdo, $postID);

?>

<br>

<div id="checkApplicationsContainer">
  <h2 style="color: #004E98;">Applications for <?php echo htmlspecialchars($postTitle['post_title']); ?></h2>
    <?php if (empty($applications)): ?>
        <p>No applications found for this job post.</p>
    <?php else: ?>
    <?php foreach ($applications as $application) : ?>
      <div class="post_container">
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></p>
        <p><strong>Message:</strong> <?php echo htmlspecialchars($application['applicant_message']); ?></p>
        <p><strong>Resume:</strong> <a href="resumePath/<?php echo htmlspecialchars($application['resumeFilePath']); ?>" target="_blank">Download</a></p>

        <form method="POST" style="display:inline;">
          <input type="hidden" name="applicationID" value="<?php echo htmlspecialchars($application['applicationID']); ?>">
          <button type="submit" name="action" value="accept" class="accept-btn">Accept</button>
          <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
          <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" id="messageButton" style="text-decoration: none;">Message Applicant</a>
        </form>

      </div>

      <br>

    <?php endforeach; ?>

<?php endif; ?>

<br><br>

<h2 style="color: #E55F00;">Accepted Applications:</h2>
<?php if (!empty($acceptedApplications)) : ?>
 <?php foreach ($acceptedApplications as $application) : ?>
    <div class="accepted_applicant">
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></p>
        <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" id="messageButton" style="text-decoration: none;">Message Applicant</a>
    </div>
 <?php endforeach; ?>
 <?php else : ?>
  <p>No accepted applications found for this job post.</p>
    <?php endif; ?>

  <br><br>

  <a href="HRHome.php" style="text-decoration: none;" class="returnButton">Return</a>
</div>

</body>
</html>