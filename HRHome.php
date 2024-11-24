<?php 

require_once 'core/handleForms.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
        header('Location: login.php');
        exit();
    }

    if(isset($_SESSION['fname'])) { ?>
        <div>Hello, <?php echo $_SESSION['fname']; ?></div>
<?php }; ?>
<br>
<h1>HR</h1>
<br><br>
<form action="core/logout.php" method="POST">
    <button type="submit">Logout</button>
</form>

</body>
</html>