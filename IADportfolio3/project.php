<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
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

    if ($rows && $rows->rowCount()>0) {
        ?>
        <table cellspacing="0" cellpadding="5" id="table">
            <tr>
                <th align='left' class='tableHead'><b>Project ID</b></th> 
                <th align='left' class='tableHead'><b>Title</b></th> 
                <th align='left' class='tableHead'><b>Start date</b></th>
                <th align='left' class='tableHead'><b>End date</b></th>
                <th align='left' class='tableHead'><b>Phase</b></th>
                <th align='left' class='tableHead'><b>Description</b></th>
                <th align='left' class='tableHead'><b>User ID</b></th>
            </tr>
    <?php
        while($row = $rows->fetch()) {
            echo "<tr class='project-row' data-pid='{$row['pid']}'><td align='left'>" . $row['pid'] . "</td>";
            echo "<td align='left'>".$row['title']."</td>";
            echo "<td align='left'>".$row['start_date']."</td>";
            echo "<td align='left'>".$row['end_date']."</td>";
            echo "<td align='left'>".$row['phase']."</td>";
            echo "<td align='left'>".$row['description']."</td>";
            echo "<td align='left'>".$row['uid']."</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p> No projects found </p>\n";
    }
} catch (PDOException $ex) {
    echo "Database error occured <br>";
    echo ($ex->getMessage());
}
?>
</body>
</html>
