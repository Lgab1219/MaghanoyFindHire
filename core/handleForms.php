<?php

session_start();

require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';



// Button submits application to database and stores resume locally
if (isset($_POST['submitApplicationBtn'])) {
    $fileName = $_FILES['resume']['name'];
    $tempFileName = $_FILES['resume']['tmp_name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $uniqueID = sha1(md5(rand(1, 9999999)));
    $completeFileName = $uniqueID . "." . $fileExtension;
    $filePath = "../resumePath/" . $completeFileName;

    // Validate file type and size
    $allowedExtensions = ['pdf'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    // Check if the file uploaded is PDF or not
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['message'] = "Invalid file type. Only PDF files are allowed.";
        header('Location: ../ApplicationForm.php?postID=' . $_POST['postID']);
        exit();
    }

    // Check if file size is too large
    if ($_FILES['resume']['size'] > $maxFileSize) {
        $_SESSION['message'] = "File is too large. Maximum allowed size is 2MB.";
        header('Location: ../ApplicationForm.php?postID=' . $_POST['postID']);
        exit();
    }

    if (move_uploaded_file($tempFileName, $filePath)) {
        $_SESSION['message'] = "File uploaded successfully!";
        
        // Retrieve accountID from the database
        $stmt = $pdo->prepare("SELECT accountID FROM accounts WHERE fname = :fname AND role = 'applicant'");
        $stmt->execute([':fname' => $_SESSION['fname']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account) {
            $postID = $_POST['postID'];
            $accountID = $account['accountID'];
            $applicant_message = trim($_POST['applicant_message']);

            uploadApplication($pdo, $postID, $accountID, $applicant_message, $completeFileName);

            header('Location: ../ApplicantHome.php');
            exit();
        } else {
            $_SESSION['message'] = "Unable to retrieve your account information.";
            header('Location: ../ApplicationForm.php?postID=' . $_POST['postID']);
            exit();
        }
    } else {
        $_SESSION['message'] = "File upload failed.";
        header('Location: ../ApplicationForm.php?postID=' . $_POST['postID']);
        exit();
    }
}

// Deletes job post by ID
if (isset($_POST['deletePostBtn'])) {
    $postID = sanitizeInput($_POST['postID']);
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];

    $query = deletePost($pdo, $postID, $fname, $lname);

    if ($query) {
        // Set a JavaScript variable to indicate successful deletion
        echo "<script>window.parent.postMessage('post_deleted', '*');</script>";
        exit();
    } else {
        echo "<div>Post deletion not successful.</div>";
    }
}



// Button to search for specific job posts
if (isset($_POST['searchJobUserBtn'])) {
    $search = sanitizeInput($_POST['search']);

    // Retrieve the logged-in user's first and last name from the session
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];

    $searchUserResults = searchPostUser($pdo, "%$search%", $fname, $lname);

    // Store the search results in the session
    $_SESSION['searchUserResults'] = $searchUserResults;

    header('Location: ../HRHome.php');
    exit();
}

// Button to search for specific job posts
if (isset($_POST['searchJobBtn'])) {
    unset($_SESSION['searchResults']); // Clear previous search results

    // Retrieve search input and logged-in user's role
    $search = sanitizeInput($_POST['search']);
    $role = $_SESSION['role'];

    // Perform the search
    if ($role === 'hr') {
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $searchResults = searchPost($pdo, "%$search%");
    } elseif ($role === 'applicant') {
        $searchResults = searchPost($pdo, "%$search%"); // General search for applicants
    }

    // Store search results in the session and redirect
    if ($searchResults !== false) {
        $_SESSION['searchResults'] = $searchResults;
    } else {
        $_SESSION['message'] = "No results found.";
    }

    // Redirect based on role
    if ($role === 'hr') {
        header('Location: ../HRHome.php');
    } elseif ($role === 'applicant') {
        header('Location: ../ApplicantHome.php');
    }
    exit();
}


// Creates a job post
if (isset($_POST['createPostBtn'])) {
    $post_title = sanitizeInput($_POST['post_title']);
    $post_desc = sanitizeInput($_POST['post_desc']);

    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];

    if (!empty($post_title || !empty($post_desc))) {
        $createPost = createPost($pdo, $post_title, $post_desc, $fname, $lname);

        if($createPost) {
            header('Location: ../HRHome.php');
            exit();
        } else {
            $_SESSION['message'] = "Please fill out all the forms!";
        }
    }
}

// Logins account
if (isset($_POST['loginUserBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) || !empty($password)) {
        $loginQuery = loginAccount($pdo, $email, $password);

        if ($loginQuery) {
            $fnameDB = $loginQuery['fname'];
            $lnameDB = $loginQuery['lname'];
            $roleDB = $loginQuery['role'];
            $_SESSION['fname'] = $fnameDB;
            $_SESSION['lname'] = $lnameDB;
            $_SESSION['role'] = $roleDB;
            $_SESSION['accountID'] = $loginQuery['accountID'];
        
            if ($roleDB == "hr") {
                header("Location: ../HRHome.php");
            } elseif ($roleDB == "applicant") {
                header("Location: ../ApplicantHome.php");
            }
            exit();
        } else {
            $_SESSION['message'] = "Incorrect username or password.";
            header("Location: ../login.php");
            exit();
        }
        
    } else {
        $_SESSION['message'] = "Please fill in all fields.";
        header("Location: ../login.php");
        exit();
    }
}

// Registers an account to the database
if (isset($_POST['registerUserBtn'])) {
    $fname = sanitizeInput($_POST['fname']);
    $lname = sanitizeInput($_POST['lname']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $role = sanitizeInput($_POST['role']);

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($role)) {
        $insertQuery = registerAccount($pdo, $fname, $lname, $email, $password, $role);

        if ($insertQuery) {
            $_SESSION['message'] = "Account registered successfully!";
            header("Location: ../login.php");
            exit();
        } else {
            $_SESSION['message'] = "An error occurred during registration.";
            header("Location: ../register.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Please fill in all fields.";
        header("Location: ../register.php");
        
    }
}