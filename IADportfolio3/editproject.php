<?php
session_start();

if(isset($_GET['pid'])) {
    $pid = $_GET['pid'];

    $_SESSION['pid'] = $pid;
    echo "PID: " . $pid;
} else {
    echo "PID not found in URL";
}


require_once("connectdb.php");

try {
    $query = "SELECT * FROM projects WHERE pid = $pid";
    $rows = $db->query($query);
    if ($rows->rowCount() > 0) {
        $row = $rows->fetch(PDO::FETCH_ASSOC);
        $title = $row['title'];
        $startdate = $row['start_date'];
        $enddate = $row['end_date'];
        $phase = $row['phase'];
        $description = $row['description'];
    } 
} catch (PDOException $ex) {
    echo("Couldn't connect to the database.<br>");
    echo($ex ->getMessage());
}

if (isset($_POST['submitted'])){

    $newtitle = $_POST['title'];
    $newstart = strtotime($_POST['startDate']);
    $newstart = date('Y-m-d H:i:s', $newstart);
    $newend = strtotime($_POST['endDate']);
    $newend = date('Y-m-d H:i:s', $newend);
    $newphase = $_POST['devphase'];
    $newdescription = $_POST['description'];

    try {
        $stat = $db->prepare("UPDATE projects SET title = (?), start_date = (?), end_date = (?), phase = (?), description = (?) WHERE pid = $pid");
        $stat->execute(array($newtitle, $newstart, $newend, $newphase, $newdescription));
        header("Location: userhome.php");
        exit();
        } catch (PDOException $ex) {
            echo("Couldn't connect to the database.<br>");
            echo($ex ->getMessage());
    } 
}

if (isset($_POST['delete'])){
    try {
        $stat = $db->prepare("DELETE FROM projects WHERE pid = $pid");
        $stat->execute();
        header("Location: userhome.php");
        exit();
        } catch (PDOException $ex) {
            echo("Couldn't connect to the database.<br>");
            echo($ex ->getMessage());
    } 
}


?>

<!DOCTYPE HTML>
<html lang = "en">

<head>
    <title> Edit </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
    <h2>Edit project</h2>
    <form method= "post">
    <div class="userInput">
        <p>Project title: <input type="text" name= "title" value="<?php echo $title; ?>" required/></p>
    </div>
    <div class="userInput">
        <p>Start date: <input type="date" name= "startDate" value="<?php echo $startdate; ?>" required/></p>
    </div>
    <div class="userInput">
        <p>End date: <input type="date" name= "endDate" value="<?php echo $enddate; ?>" required/></p>
    </div>  
    <div class="userInput">
        <p>Phase: <select name="devphase" value="<?php echo $phase; ?>" required/></p>
                <option value="design" <?php if ($phase == 'design') echo 'selected'; ?>>design</option>
                <option value="development" <?php if ($phase == 'development') echo 'selected'; ?>>development</option>
                <option value="testing" <?php if ($phase == 'testing') echo 'selected'; ?>>testing</option>
                <option value="deployment" <?php if ($phase == 'deployment') echo 'selected'; ?>>deployment</option>
                <option value="complete" <?php if ($phase == 'complete') echo 'selected'; ?>>complete</option>
            </select>
    </div>
        <p><label for="description" style="font-size:24px">Description:</label></p>
        <div class="userInput">
            <textarea name="description" id="description" rows="4" cols="50" required><?php echo $description; ?></textarea> <br>
        </div>
        <div class="submitInput">
            <input type= "submit" value= "Update project" name= "submitted"/>
        </div>
        <div class="submitInput">
            <input type= "submit" value= "Delete project" name= "delete"/>
        </div>
</form>
</body>
