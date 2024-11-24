<?php 

require_once 'core/dbConfig.php';
require_once 'core/models.php';
require_once 'core/handleForms.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire Register</title>
</head>
<body>

    <div class="nav_bar">
        <span class="logo">
            <h1>FindHire</h1>
        </span>
    </div>

    <?php
    if (isset($_SESSION['message'])) { ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); } ?>

    <div class="main">
        <div class="form">
            <h2>Register</h2>
            <form action="core/handleForms.php" method="POST">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="register_fname">
                <br><br>

                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="register_lname">
                <br><br>

                <label for="email">Email</label>
                <input type="text" name="email" id="register_email">
                <br><br>

                <label for="password">Password</label>
                <input type="password" name="password" id="register_password">
                <br><br>

                <label for="role">Role</label>
                <select name="role" id="register_role">
                    <option value="none" selected disabled></option>
                    <option value="hr">Human Resources (HR)</option>
                    <option value="applicant">Applicant</option>
                </select>
                <br><br>

                <input type="submit" value="Register" name="registerUserBtn">
            </form>
            <p>Already have an account? Log in <a href="login.php">here</a>!</p>
        </div>

        <div class="account"></div>
    </div>
</body>
</html>