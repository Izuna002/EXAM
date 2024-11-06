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
    <title>Login</title>
    <style>
        body {
            font-family: "Arial";
        }
        input {
            font-size: 1.5em;
            height: 50px;
            width: 200px;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['message'])): ?> 
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
        <?php unset($_SESSION['message']); ?> 
    <?php endif; ?>

    <h1>Login Now!</h1>
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username">
        </p>
        <p>
            <label for="password">Password</label> 
            <input type="password" name="password">
        </p>
        <p> 
            <input type="submit" name="loginUserBtn" value="Login"> 
        </p>
    </form>
    <p>Don't have an account? You may register <a href="register.php">here</a></p>
</body>
</html>