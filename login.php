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
    <title>FindHire Login</title>
</head>
<body>

    
    <div class="nav_bar">
        <span class="logo">
            <h1>FindHire</h1>
        </span>
    </div>
    
    <div class="main">
        
        <?php
            if(isset($_SESSION['message'])) { ?>
            <div><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); }  ?>

        <div class="form">
            <h2>Login</h2>
            <form action="core/handleForms.php" method="POST">
                <label for="email">Email</label>
                <input type="text" name="email" id="login_email" required>
                <br><br>

                <label for="password">Password</label>
                <input type="password" name="password" id="login_password" required>
                <br><br>

                <input type="submit" value="Login" name="loginUserBtn">
            </form>
            <p>Don't have an account? Register <a href="register.php">here</a>!</p>
        </div>

    <br><br>
    <button><a href="core/unset.php" style="text-decoration: none; color: black;">Reset</a></button>

        <div class="account"></div>
    </div>
</body>
</html>