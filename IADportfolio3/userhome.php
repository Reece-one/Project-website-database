<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>

<?php
session_start();
require_once("connectdb.php");
include("functions.php");

if (isset($_SESSION['username'])){
    if (isset($_SESSION['data'])){
        echo "Success! your new project ID is" . $_SESSION['data'];
        unset($_SESSION['data']);
    }

    $username=$_SESSION['username'];
    echo "<h2> Welcome ".$_SESSION['username'].".</h2>";

    $query = "SELECT uid FROM users WHERE username = '" . $_SESSION['username'] . "'";
    $result = $db->query($query);

    if ($result->rowCount() > 0) {
        $row = $result->fetch();
        $uid = $row['uid'];
        echo "User ID: " . $uid;
    } else {
        echo "User not found";
    } 

    echo '<form action="userhome.php" method="get">';
    echo '<div class="submitInput">';
    echo '<input type="submit" value="Log out" name="logOut" />';
    echo '</div>';
    echo '</form>';

    echo '<form action="addproject.php">';
    echo '<div class="submitInput">';
    echo '<input type="submit" value="Add a project" />';
    echo '</div>';
    echo '</form>';


    echo "<h3> My Projects </h3>";
    loadTable($db, "SELECT * FROM projects WHERE uid = $uid", "myproject-row");
    tableNav("myproject-row", "editproject.php");

    if(isset($_GET['logOut'])) {
        session_unset();
        session_destroy();
        echo "<script>location.reload(true);</script>";
    }
}

echo '<form action="search.php">';
echo '<div class="submitInput">';
echo '<input type="submit" value="Search projects" />';
echo '</div>';
echo '</form>';

echo "<h3> Projects </h3>";
loadTable($db, "SELECT * FROM projects", "project-row");
tableNav("project-row", "project.php");

if (!isset($_SESSION['username'])){
    echo '<p style="margin-top:20px"> Already a user? <a href="index.php"> Log in </a> or <a href="register.php"> Register </a></p>';
}
?>
</body>
</html>



