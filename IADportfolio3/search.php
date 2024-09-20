<!DOCTYPE HTML>
<head>
    <title> Search </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="style\style.css" />
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"/>
</head>
<body>
    <h2>Search</h2>
    <form method ="get" action= "search.php">
        <div class="userInput">
            <p>Project title: <input type="text" name= "title"/></p>
        </div>
        <div class="userInput">
            <p>Start date: <input type="date" name= "startDate"/></p>
        </div>
        <div class="submitInput">
            <input type= "submit" value= "search"/> <br>
        </div>
        <input type= "hidden" name= "submitted" value= "true"/> 
    </form>
</body>

<?php
session_start();
require_once("connectdb.php");

if (isset($_GET['submitted'])) {
    include("functions.php");
    $title = $_GET['title'];
    $start = strtotime($_GET['startDate']);
    $start = date('Y-m-d H:i:s', $start);

    if (!empty($_GET['title']) && !empty($_GET['startDate'])) {
        loadSearchTable($db, "SELECT * FROM projects WHERE title LIKE (?) AND start_date = (?)", ["%" . $title . "%", $start], "project-row");
    } else if (!empty($_GET['title'])) {
        loadSearchTable($db, "SELECT * FROM projects WHERE title LIKE (?)", ["%" . $title . "%"], "project-row");
    } else if (!empty($_GET['startDate'])) {
        loadSearchTable($db, "SELECT * FROM projects WHERE start_date = (?)", [$start], "project-row");
    } else {
        echo "<p> Please fill in both title and start date fields </p>\n";
    } 
    tableNav("project-row", "project.php");
}
?>