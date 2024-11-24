<?php

session_start();

require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';

// Logins account
if (isset($_POST['loginUserBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) || !empty($password)) {
        $loginQuery = loginAccount($pdo, $email, $password);

        if ($loginQuery) {
            $fnameDB = $loginQuery['fname'];
            $roleDB = $loginQuery['role'];
            $_SESSION['fname'] = $fnameDB;
            $_SESSION['role'] = $roleDB;
        
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