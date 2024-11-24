<?php

include_once 'dbConfig.php';

session_start();

$deleteApplicants = "DELETE FROM accounts";
$resetApplicantsIncrement = "ALTER TABLE accounts AUTO_INCREMENT = 1";


$deleteStatement = $pdo -> prepare($deleteApplicants);
$resetStatement = $pdo -> prepare($resetApplicantsIncrement);

$executeQuery = $deleteStatement -> execute();
$executeQuery = $resetStatement -> execute();

if($executeQuery){
    header("Location: ../login.php");
    return true;
}

session_unset();