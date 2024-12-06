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

if (isset($_SESSION['fname'])) { ?>
    <div class="account">Hello, Applicant <?php echo htmlspecialchars($_SESSION['fname']); ?></div>
<?php } else {
    header('Location: login.php');
}

// Fetch accountID based on logged-in user's fname and lname
$accountID = getAccountID($pdo, $_SESSION['fname'], $_SESSION['lname']);

// Fetch application statuses for the applicant (both accepted and rejected)
$appStatus = getApplicationStatus($pdo, $accountID);

// Fetch posts, either from session or from the database
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

    <?php if (is_array($posts) && !empty($posts)) : ?>
        <?php foreach ($posts as $post) : 
            $hasApplied = hasApplicantApplied($pdo, $accountID, $post['postID']);
            $postStatus = "Pending";

            foreach ($appStatus as $status) {
                if ($status['postID'] == $post['postID']) {
                    $postStatus = $status['status'];
                    break;
                }
            }
        ?>

        <div class="post_container" style="width: 50%;">
            <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
            <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
            <h4>Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>

            <?php if ($hasApplied && $postStatus == "Pending") : ?>
                <p><em>You have already applied for this job.</em></p>
                <p>Status: <strong><?php echo htmlspecialchars($postStatus); ?></strong></p>
                <button>
                    <a href="Messenger.php?postID=<?php echo $post['postID']; ?>" style="text-decoration: none; color: black;">Message HR</a>
                </button>

            <?php elseif (!$hasApplied && $postStatus == "Accepted") : ?>
                <p><em>You have already applied for this job.</em></p>
                <p>Status: <strong><?php echo htmlspecialchars($postStatus); ?></strong></p>
                <button>
                    <a href="Messenger.php?postID=<?php echo $post['postID']; ?>" style="text-decoration: none; color: black;">Message HR</a>
                </button>

            <?php else : ?>
                <button>
                    <a href="ApplicationForm.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none; color: black;">Submit an application</a>
                </button>
            <?php endif; ?>
        </div>

        <br>

        <?php endforeach; ?>
    <?php else : ?>
        <p>No job posts available.</p>
    <?php endif; ?>

    <form action="core/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</div>

</body>
</html>
