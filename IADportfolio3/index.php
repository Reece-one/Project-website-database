<?php
if (isset($_POST['submitted'])){
    if (!isset($_POST['username'], $_POST['password'])) {
        exit('Please fill in both fields');
    }
    require_once('connectdb.php');
    try {
        $stat = $db->prepare('SELECT password FROM users WHERE username = ?');
        $stat->execute(array($_POST['username']));

        if ($stat->rowCount()>0) {
            $row = $stat->fetch();
            if (password_verify($_POST['password'], $row['password'])) {
                session_start();
                $_SESSION["username"]=$_POST['username'];
                header("Location:userhome.php");
                exit();
            } else {
                echo "<p>Invalid password</p>";
            }
        } else {
            echo "<p>username not found</p>";
        }
    } catch (PDOException $ex) {
        echo ("Failed to connect to database.<br>");
        echo ($ex->getMessage());
    }
}
?>
<head>
    <title> Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class ="inputBox">
        <h2>Log In</h2>
        <form method= "post" action= "index.php">
            <div class="userInput">
                <input type="text" name= "username" placeholder="Username"/> <br>
            </div>
            <div class="userInput">
                <input type="password" name= "password" placeholder="Password"/> <br>
            </div>
            <div class="submitInput">
                <input type= "submit" value= "Log in"/> <br>
            </div>
            <input type= "hidden" name= "submitted" value= "true"/> 
        </form>
        <p> Not a user? <a href ="register.php"> Register here </a></p>
    </div>
</body>
