<?php

require_once 'dbConfig.php';

// Logins account
function loginAccount($pdo, $email, $password) {
    $checkQuery = "SELECT * FROM accounts WHERE email = ?";
    $statement = $pdo->prepare($checkQuery);
    
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
    $checkQuery = "SELECT * FROM accounts WHERE email = ?";
    $statement = $pdo -> prepare($checkQuery);
    $statement -> execute([$email]);
 
    if($statement -> rowCount() == 0){
 
        $insertQuery = "INSERT INTO accounts (fname, lname, email, password, role) VALUES
        (?, ?, ?, ?, ?)";
        $statement = $pdo -> prepare($insertQuery);
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