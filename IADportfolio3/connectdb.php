<?php

$db_host = 'localhost';
$db_name = 'u_220087944_aproject';
$username = 'u-220087944';
$password = 'FgGugtxd5KqihQD';

try{
   $db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password);
} catch (PDOException $ex) {
   echo("Couldn't connect to the database.<br>");
   echo($ex ->getMessage());
   exit;
}

?>