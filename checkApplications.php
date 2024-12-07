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

<div class="nav_bar">
    <span class="logo">
    <h1>FindHire</h1>
    </span>
</div>

<?php

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: ApplicantHome.php');
    exit();
    }

    if (isset($_SESSION['fname'])) { ?>
        <div class="account">Hello, HR <?php echo htmlspecialchars($_SESSION['fname']); ?></div>
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

<div class="main">
  <h2>Applications for Job Post #<?php echo htmlspecialchars($postID); ?></h2>
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
          <button type="submit" name="action" value="accept" style="color: green;">Accept</button>
          <button type="submit" name="action" value="reject" style="color: red;">Reject</button>
          <button>
          <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" style="text-decoration: none; color: black;">Message Applicant</a>
          </button>
        </form>
      </div>

      <br>

    <?php endforeach; ?>

<?php endif; ?>

<br><br>

<h2>Accepted Applications:</h2>
<?php if (!empty($acceptedApplications)) : ?>
 <?php foreach ($acceptedApplications as $application) : ?>
    <div class="accepted_applicant">
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></p>
    <button>
        <a href="Messenger.php?accountID=<?php echo htmlspecialchars($application['accountID']); ?>&postID=<?php echo $postID; ?>" style="text-decoration: none; color: black;">Message Applicant</a>
    </button>
    </div>
 <?php endforeach; ?>
    <?php endif; ?>

  <br>

  <button>
    <a href="HRHome.php" style="text-decoration: none; color: black;">Return</a>
  </button>
</div>

</body>
</html>