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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">    <title>FindHire Login</title>
    <title>FindHire Register</title>
</head>
<body>

    <div class="nav_bar">
        <span class="logo_container">
            <img src="resources/FindHire_Logo.png" alt="findhire_logo" id="logo">
        </span>
    </div>

    
    <div class="main">

        <div class="reg_form_content">
            <span>
                <h1 style="color: #004E98;">Your Next Career,<br><h1 style="color: #FF6700; margin-top: -15px;">Simplified.</h1></h1><br>
                <h2 style="color: #004E98;">Lightning-Fast Performance: </h2><p >Experience blazing-fast load times and seamless navigation.</p>
                <h2 style="color: #004E98;">Intuitive Interface: </h2><p>A user-friendly design that makes your job search a breeze.</p>
                <h2 style="color: #004E98;">Secure and Private: </h2><p>Protect your personal information with our robust security measures.</p>
            </span>
        </div>

        <div class="register_form_container">

            <?php if(isset($_SESSION['message'])) : ?>
                <p style="color: red; margin: -1em 0 0 0; text-align: center;"><?php echo $_SESSION['message']; ?></p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <h2 id="register-text">Register</h2>
            <form action="core/handleForms.php" method="POST">
                <label for="fname" class="register_fname">First Name</label>
                <input type="text" name="fname" class="register_fname" style="border: 1px solid #003B75; border-radius: 5px;">
                <br><br>

                <label for="lname" class="register_lname">Last Name</label>
                <input type="text" name="lname" class="register_lname" style="border: 1px solid #003B75; border-radius: 5px;">
                <br><br>

                <label for="email" class="register_email">Email</label>
                <input type="text" name="email" class="register_email" style="border: 1px solid #003B75; border-radius: 5px;">
                <br><br>

                <label for="password" class="register_password">Password</label>
                <input type="password" name="password" class="register_password" style="border: 1px solid #003B75; border-radius: 5px;">
                <br><br>

                <label for="role" class="register_role">Role</label>
                <select name="role" class="register_role" style="border: 1px solid #003B75; border-radius: 5px;">
                    <option value="none" selected disabled style="border: 1px solid #003B75; border-radius: 5px;"></option>
                    <option value="hr" style="border: 1px solid #003B75; border-radius: 5px;">Human Resources (HR)</option>
                    <option value="applicant" style="border: 1px solid #003B75; border-radius: 5px;">Applicant</option>
                </select>
                <br><br>

                <input type="submit" value="Register" name="registerUserBtn" id="register_button">
            </form>
            <p>Already have an account? Log in <a href="login.php">here</a>!</p>
        </div>
    </div>
</body>
</html>