<?php
session_start();
require_once 'core/models.php';
require_once 'core/dbConfig.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title> 
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h1>Register here!</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username:</label> 
            <input type="text" id="username" name="username" required> 
        </p>
        <p>
            <label for="password">Password:</label> 
            <input type="password" id="password" name="password" required> 
        </p>
        <p>
            <input type="submit" name="registerUserBtn" value="Register"> 
        </p>
    </form>
</body>
</html>