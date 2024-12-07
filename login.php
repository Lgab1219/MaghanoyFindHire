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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">    <title>FindHire Login</title>
</head>
<body>

    
    <div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
    </div>
    
    <div class="main">
        
        <?php
            if(isset($_SESSION['message'])) { ?>
            <div><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); }  ?>

        <div class="login_form_container">
            <h2 id="login-text">Login</h2>
            <form action="core/handleForms.php" method="POST" id="form">
                <label for="email" class="login_email">Email</label><br>
                <input type="text" name="email" class="login_email" style="font-size: 1.5em; border: 1px solid #FF6700; border-radius: 5px;" required>
                <br><br>

                <label for="password" class="login_password">Password</label><br>
                <input type="password" name="password" class="login_password" style="font-size: 1.5em; border: 1px solid #FF6700; border-radius: 5px;" required>
                <br><br>

                <input type="submit" value="Login" name="loginUserBtn" id="login_button">
            </form>
            <p style="margin-top: 3em;">Don't have an account? Register <a href="register.php">here</a>!</p>
        </div>

        <div class="log_form_content">
            <span>
                <h1 style="color: #004E98;">Your Next Career,<br><h1 style="color: #FF6700;">Simplified.</h1></h1><br>
                <h2 style="color: #004E98;">Lightning-Fast Performance: </h2><p >Experience blazing-fast load times and seamless navigation.</p>
                <h2 style="color: #004E98;">Intuitive Interface: </h2><p>A user-friendly design that makes your job search a breeze.</p>
                <h2 style="color: #004E98;">Secure and Private: </h2><p>Protect your personal information with our robust security measures.</p>
            </span>
        </div>

    <br><br>

    </div>
</body>
</html>