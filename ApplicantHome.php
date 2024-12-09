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

    <!-- Navbar -->
    <div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
    </div>

    <?php
    // Role-based redirection
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
        header('Location: HRHome.php');
        exit();
    }
    ?>

    <?php if (isset($_SESSION['fname'])) : ?>
        <div id="applicant_account_container">
            <div id="applicant_account">
                <h3 style="color: white;">Hello, <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h3>
            </div>
            <form action="core/logout.php" method="POST" style="margin: -8em 0 0 -2em;">
                <button type="submit" class="logout_button">Logout</button>
            </form>
        </div>
    <?php else : header('Location: login.php'); endif; ?>

    <br><br><br>

    <?php 
    // Fetching accountID for the logged-in user
    $accountID = getAccountID($pdo, $_SESSION['fname'], $_SESSION['lname']);
    $appStatus = getApplicationStatus($pdo, $accountID); // Fetching application statuses

    // Fetching posts based on session or default database data
    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
    $posts = empty($searchResults) ? getAllPosts($pdo) : $searchResults;
    ?>

    <div class="applicant_main">
        <h2>Jobs available</h2>

        <!-- Job Search Form -->
        <form action="core/handleForms.php" method="POST">
            <input type="text" name="search" placeholder="Search for a job post:" class="searchJobUserInput">
            <input type="submit" value="Search" name="searchJobBtn" class="searchJobUserButton">
        </form><br><br>

        <div class="searchResults">
            <!-- Displaying Posts -->
            <?php if (is_array($posts) && !empty($posts)) : ?>
                <?php foreach ($posts as $post) : 
                    // Check if the applicant has already applied for the post
                    $hasApplied = hasApplicantApplied($pdo, $accountID, $post['postID']);
                    $postStatus = "Pending";
                
                        foreach ($appStatus as $status) {
                            if ($status['postID'] == $post['postID']) {
                                $postStatus = $status['status'];
                                break;
                            }
                        }
                ?>
                    <!-- Post Container -->
                    <div id="applicant_post_container" style="width: 50%;">
                        <h3><?php echo htmlspecialchars($post['post_title']); ?></h3>
                        <p><?php echo htmlspecialchars($post['post_desc']); ?></p>
                        <h4>Posted by: <?php echo htmlspecialchars($post['fname'] . ' ' . $post['lname']); ?></h4>
                
                            <!-- Status Display & Application Buttons -->
                            <?php if ($hasApplied && $postStatus == "Pending") : ?>
                                <p><em>You have already applied for this job.</em></p>
                                <p>Status: <strong><?php echo htmlspecialchars($postStatus); ?></strong></p>
                                <button><a href="Messenger.php?accountID=<?php echo $accountID; ?>&postID=<?php echo $post['postID']; ?>" style="text-decoration: none; color: black;">Message HR</a></button>
                            <?php elseif (!$hasApplied && $postStatus == "Accepted") : ?>
                            <p><em>You have already applied for this job.</em></p>
                            <p>Status: <strong><?php echo htmlspecialchars($postStatus); ?></strong></p>
                            <button><a href="Messenger.php?accountID=<?php echo $accountID; ?>&postID=<?php echo $post['postID']; ?>" style="text-decoration: none; color: black;">Message HR</a></button>
                        <?php else : ?>
                            <button><a href="ApplicationForm.php?postID=<?php echo htmlspecialchars($post['postID']); ?>" style="text-decoration: none; color: black;">Submit an application</a></button>
                        <?php endif; ?>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No job posts available.</p>
            <?php endif; ?>
    </div>
</div>

</body>
</html>
