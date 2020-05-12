<?php

    session_start();

    if (isset($_SESSION["user_id"])){
        header("Location: /php-login");
    }

    require "database.php";

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $records = $conn->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $records->bindParam(":email", $_POST["email"]);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $message = "";

        if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header("Location: /php-login");
        } else {
            $message = 'Sorry, those credentials do not match';
        }
    }

?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php require "partials/header.php" ?>
    <?php if (!empty($message)) : ?>
    <p><?= $message ?></p>
    <?php endif; ?>

    <h1>Login</h1>
    <span>or <a href="signup.php">SignUp</a></span>

    <form action="login.php" method="post">
        <input type="text" name="email" placeholder="Enter Your Mail">
        <input type="password" name="password" placeholder="Enter Your Password">
        <input type="submit" value="Send">
    </form>
    
</body>
</html>