<?php
    require "database.php";
    session_start();

    if (isset($_SESSION["user_id"])){
        header("Location: /php-login");
    }

    $message = "";

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email",$_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $stmt->bindParam(":password",$password);

        if ($stmt->execute()) {
            $message = "Successfully";
        } else {
            $message = "Sorry There Must Have Been An Issue Creating Your Accout";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SigUp</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php require "partials/header.php" ?>

    <?php if (!empty($message)): ?>
    <p><?= $message ?></p>
    <?php endif; ?>

    <h1>SigUp</h1>
    <span>or <a href="login.php">Login</a></span>

    <form action="signup.php" method="post">
        <input type="text" name="email" placeholder="Enter Your Mail">
        <input type="password" name="password" placeholder="Enter Your Password">
        <input type="password" name="confirm_password" placeholder="Confirm Your Password">
        <input type="submit" value="Send">
    </form>
    
</body>
</html>