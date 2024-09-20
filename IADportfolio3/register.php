<?php
if (isset($_POST['submitted'])){
    require_once('connectdb.php');

    $username=isset($_POST['username'])?$_POST['username']:false;
    $email=isset($_POST['email'])?$_POST['email']:false;
    $password=isset($_POST['password'])?$_POST['password']:false;
    $verifyPassword=isset($_POST['verifyPassword'])?$_POST['verifyPassword']:false;


    if (!($username)) {
        echo "Enter a userame";
        exit;
    }
    if (!($password)) {
        echo "Enter a password";
        exit;
    }
    if (!($verifyPassword)) {
        echo "Verify password";
        exit;
    }
    if (!($password === $verifyPassword)) {
        echo "Passwords do not match";
        exit;
    } else {
        $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    if (!($email)) {
        echo "Enter an Email";
        exit;
    }

    $userQuery = $db->prepare("SELECT * FROM users WHERE username = ?");
    $userQuery->execute([$username]);
    $existingUser = $userQuery->fetch();
    if ($existingUser) {
        echo "Username already exists. Please choose a different one.";
        exit;
    }

    $emailQuery = $db->prepare("SELECT * FROM users WHERE email = ?");
    $emailQuery->execute([$email]);
    $existingEmail = $emailQuery->fetch();
    if ($existingEmail) {
        echo "Email address already exists. Please use a different one.";
        exit;
    }


    try {
        $stat = $db->prepare("INSERT INTO users VALUES(default,?,?,?)");
        $stat->execute(array($username, $password, $email));
        $id=$db->lastInsertId();
        echo "Your user id is: $id";
        } catch (PDOException $ex) {
            echo("Couldn't connect to the database.<br>");
            echo($ex ->getMessage());
    }
}
?>

<!DOCTYPE HTML>
<html lang = "en">
<head>
    <title> Register </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="inputBox">
        <h2>Register</h2>
        <form method= "post" action= "register.php">
            <div class="userInput">
                <input type="text" name= "username" placeholder="Username"/> <br>
            </div>
            <div class="userInput">
                <input type="email" name= "email" placeholder="E-mail"/> <br>
            </div>
            <div class="userInput">
                <input type="text" name= "password" placeholder="Password"/> <br>
            </div>
            <div class="userInput">
                <input type="text" name= "verifyPassword" placeholder="Verify Password"/> <br>
            </div>
            <div class="submitInput">
                <input type= "submit" value= "Register"/> <br>
            </div>    
            <input type= "hidden" name= "submitted" value= "true"/> 
        </form>
    </div>
<p> Already a user? <a href ="index.php"> Log in </a></p>
</body>