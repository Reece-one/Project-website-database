<?php
session_start();
if (! isset($_SESSION['username'])){
header("Location: index.php");
exit();
}

if (isset($_POST['submitted'])){
    require_once('connectdb.php');

    $title = $_POST['title'];
    $start = strtotime($_POST['startDate']);
    $start = date('Y-m-d H:i:s', $start);
    $end = strtotime($_POST['endDate']);
    $end = date('Y-m-d H:i:s', $end);
    $phase = $_POST['devphase'];
    $description = $_POST['description'];

    
    try {
        $query = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
        $rows = $db->query($query);
        if ($rows->rowCount() > 0) {
            $row = $rows->fetch(PDO::FETCH_ASSOC);
            $uid = $row['uid'];
        } 
    } catch (PDOException $e) {
        echo("Couldn't connect to the database.<br>");
        echo($ex ->getMessage());
    }


    try {
        if ($end < $start) {
            echo "<p>End date cannot be before start date.</p>";
        } else {
        $stat = $db->prepare("INSERT INTO projects VALUES(default,?,?,?,?,?,?)");
        $stat->execute(array($title, $start, $end, $phase, $description, $uid));
        $pid=$db->lastInsertId();
        $_SESSION['data'] = $pid;
        header("Location: userhome.php");
        exit();
        }
        } catch (PDOException $ex) {
            echo("Couldn't connect to the database.<br>");
            echo($ex ->getMessage());
    } 
}
?>

<!DOCTYPE HTML>
<html lang = "en">
<head>
    <title> AddProject </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
    <h2>Add a project</h2>
    <form method= "post" action= "addproject.php">
        <div class="userInput">
            <p>Project title: <input type="text" name= "title" required/></p>
</div>
            <div class="userInput">
        <p>Start date: <input type="date" name= "startDate" required/></p>
</div>
        <div class="userInput">
        <p>End date: <input type="date" name= "endDate" required/></p>
</div>
        <div class="userInput">
        <p>Phase: <select name="devphase" required></p>
                <option value="design">design</option>
                <option value="development">development</option>
                <option value="testing">testing</option>
                <option value="deployment">deployment</option>
                <option value="complete">complete</option>
        </select>
        <p><label for="description">Description:</label></p>
        <div class="userInput">
        <textarea id="description" name="description" rows="4" cols="50" required></textarea> </br>
        <div class="submitInput">
            <input type= "submit" value= "Add project"/> <br>
        </div>
        <input type= "hidden" name= "submitted" value= "true"/> 
    </form>
</body>