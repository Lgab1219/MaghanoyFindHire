<?php

require_once 'dbConfig.php';



// Checks whether an applicant's submitted application is accepted or rejected
function getApplicationStatus($pdo, $accountID) {
    $acceptedQuery = "
        SELECT aa.postID, jp.post_title, 'Accepted' AS status 
        FROM accepted_applications aa 
        JOIN job_posts jp ON aa.postID = jp.postID 
        WHERE aa.accountID = :accountID
    ";
    
    $stmt = $pdo->prepare($acceptedQuery);
    $stmt->execute(['accountID' => $accountID]);
    return $stmt->fetchAll();
}


// When HR accepts application, a query gets sent to the accepted applications table
function acceptApplication($pdo, $applicationID) {
    $query = "
        INSERT INTO accepted_applications (postID, accountID, fname, lname)
        SELECT a.postID, a.accountID, ac.fname, ac.lname
        FROM applications a
        JOIN accounts ac ON a.accountID = ac.accountID
        WHERE a.applicationID = :applicationID
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['applicationID' => $applicationID]);

    // Remove the application from the applications table
    $deleteQuery = "DELETE FROM applications WHERE applicationID = :applicationID";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['applicationID' => $applicationID]);
}


// When HR rejects application, a query deletes the submitted application
function rejectApplication($pdo, $applicationID) {
    $deleteQuery = "DELETE FROM applications WHERE applicationID = :applicationID";
    $stmt = $pdo->prepare($deleteQuery);
    $stmt->execute(['applicationID' => $applicationID]);
}



// Check if an applicant has submitted an application in a specific job post
function hasApplicantApplied($pdo, $accountID, $postID) {
    $query = "SELECT COUNT(*) FROM applications WHERE accountID = :accountID AND postID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['accountID' => $accountID, 'postID' => $postID]);
    return $stmt->fetchColumn() > 0;
}


// Get applications by id
function getApplicationsByPostID($pdo, $postID) {
    $stmt = $pdo->prepare("
        SELECT a.*, acc.fname, acc.lname 
        FROM applications a
        JOIN accounts acc ON a.accountID = acc.accountID
        WHERE a.postID = :postID
    ");
    $stmt->execute(['postID' => $postID]);
    return $stmt->fetchAll();
}



// Get all applications
function getAllApplications($pdo) {
    $stmt = $pdo->prepare("
        SELECT a.applicationID, a.applicant_message, a.resumeFilePath, ac.fname, ac.lname, jp.post_title 
        FROM applications a
        INNER JOIN accounts ac ON a.accountID = ac.accountID
        INNER JOIN job_posts jp ON a.postID = jp.postID
        ORDER BY a.applicationID DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}


// Uploads application to the database and the resume in the file path
function uploadApplication($pdo, $postID, $accountID, $applicant_message, $resumeFilePath) {
    $stmt = $pdo->prepare("
        INSERT INTO applications (postID, accountID, applicant_message, resumeFilePath)
        VALUES (?, ?, ?, ?)
    ");
    
    $stmt->execute([$postID, $accountID, $applicant_message, $resumeFilePath
    ]);

    $_SESSION['message'] = "Application submitted successfully!";
}

// Selects specific post by ID
function getPostById($pdo, $postID) {
    $query = "SELECT * FROM job_posts WHERE postID = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$postID]);
    return $statement->fetch();
}


// Deletes specific job post
function deletePost($pdo, $postID, $fname, $lname) {
    $query = "DELETE FROM job_posts WHERE postID = ? AND fname = ? AND lname = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$postID, $fname, $lname]);

    if ($executeQuery) {
        return true;
    }
}

// Search for job posts
function searchPostUser($pdo, $search, $fname, $lname){
    $query = "SELECT * FROM job_posts WHERE (post_title LIKE ? OR post_desc LIKE ?) AND fname = ? AND lname = ?";
    $statement = $pdo->prepare($query);

    $executeQuery = $statement -> execute([$search, $search, $fname, $lname]);

    if($executeQuery){
        $searchUserResults = $statement -> fetchAll();
        return $searchUserResults;
    } else {
        echo "Failed to search job post";
    }
 }

// Get all job posts created by the user who logged in
function getAllPostsOfUser($pdo, $fname, $lname){
    $getQuery = "SELECT * FROM job_posts WHERE fname = ? AND lname = ?";
    $statement = $pdo -> prepare($getQuery);
    $executeQuery = $statement -> execute([$fname, $lname]);

   if($executeQuery){
       return $statement -> fetchAll();
   }

}

// Search for job posts
function searchPost($pdo, $search){
    $query = "SELECT * FROM job_posts WHERE post_title LIKE ? OR post_desc LIKE ? OR fname LIKE ? OR lname LIKE ?";
    $statement = $pdo->prepare($query);

    $executeQuery = $statement -> execute([$search, $search, $search, $search]);

    if($executeQuery){
        $searchResults = $statement -> fetchAll();
        return $searchResults;
    } else {
        echo "Failed to search job post";
    }
 }

// Get all job posts
function getAllPosts($pdo){
    $getQuery = "SELECT * FROM job_posts";
    $statement = $pdo -> prepare($getQuery);
    $executeQuery = $statement -> execute();

   if($executeQuery){
       return $statement -> fetchAll();
   }

}

// Adds a new post in the database
function createPost($pdo, $post_title, $post_desc, $fname, $lname){

    //Check if there are duplicate posts
    $check = "SELECT * FROM job_posts WHERE post_title = ? AND post_desc = ?";
    $statement = $pdo -> prepare($check);

    if($statement -> rowCount() == 0){

        $insert = "INSERT INTO job_posts (post_title, post_desc, fname, lname) VALUES
        (?, ?, ?, ?)";
        $statement = $pdo -> prepare($insert);
        $executeQuery = $statement -> execute([$post_title, $post_desc, $fname, $lname]);

        if($executeQuery){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Get account by ID
function getAccountID($pdo, $fname, $lname) {
    $query = "SELECT accountID FROM accounts WHERE fname = :fname AND lname = :lname LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['fname' => $fname, 'lname' => $lname]);
    return $stmt->fetchColumn();
}


// Logins account
function loginAccount($pdo, $email, $password) {
    $check = "SELECT * FROM accounts WHERE email = ?";
    $statement = $pdo->prepare($check);
    
    if ($statement->execute([$email]) && $statement->rowCount() > 0) {
        $accountInfo = $statement->fetch();
        if (password_verify($password, $accountInfo['password'])) {
            return $accountInfo; // Return user data on success
        }
    }
    return false; // Return false if login fails
}


// Registers account to database
function registerAccount($pdo, $fname, $lname, $email, $password, $role){
    $check = "SELECT * FROM accounts WHERE email = ?";
    $statement = $pdo -> prepare($check);
    $statement -> execute([$email]);
 
    if($statement -> rowCount() == 0){
 
        $insert = "INSERT INTO accounts (fname, lname, email, password, role) VALUES
        (?, ?, ?, ?, ?)";
        $statement = $pdo -> prepare($insert);
        $executeQuery = $statement -> execute([$fname, $lname, $email, $password, $role]);
 
        if($executeQuery){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
 }