<?php
require_once("connectdb.php");


//loads a database query and gives the loaded rows a class.
function loadTable($db, $query, $rowClass) { 
try {
    $rows = $db->query($query);

    if ($rows && $rows->rowCount()>0) {
        ?>
        <table cellspacing="0" cellpadding="5" id="table">
            <tr><th align='left' class='tableHead'><b>Title</b></th> <th align='left' class='tableHead'><b>Start date</b></th> <th align='left' class='tableHead'><b>Description</b></th></tr>
    <?php
        while($row = $rows->fetch()) {
            echo "<tr class='{$rowClass}' data-pid='{$row['pid']}'><td align='left'>" . $row['title'] . "</td>";
            echo "<td align='left'>".$row['start_date']."</td>";
            echo "<td align='left'>".$row['description']."</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p> No projects found </p>\n";
    }
} catch (PDOException $ex) {
    echo "Database error occured <br>";
    echo ($ex->getMessage());
}
}

//Loads a table from search. Similar to the above function but takes input from a form and protects against injection
function loadSearchTable($db, $query, $execute, $rowClass) {
    $stat = $db->prepare($query);
    $stat->execute($execute);
    $row = $stat->fetchAll();
    if ($row && $stat->rowCount() > 0) {
?>
        <table cellspacing="0" cellpadding="5" id="table">
            <tr>
                <th align='left' class='tableHead'><b>Title</b></th>
                <th align='left' class='tableHead'><b>Start date</b></th>
                <th align='left' class='tableHead'><b>Description</b></th>
            </tr>
<?php
        foreach ($row as $row) {
            echo "<tr class='{$rowClass}' data-pid='{$row['pid']}'><td align='left'>" . $row['title'] . "</td>";
            echo "<td align='left'>" . $row['start_date'] . "</td>";
            echo "<td align='left'>" . $row['description'] . "</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p> No projects found </p>\n";
    }
}




//Makes loadTable() tables clickable and redirected to a page when clicked
function tableNav($rowClass, $url) {
    echo '<script>';
    echo 'document.addEventListener(\'DOMContentLoaded\', function() {';
    echo     'var projectRows = document.querySelectorAll(\'.' . $rowClass . '\');';
 
    echo     'projectRows.forEach(function(row) {';
    echo         'row.addEventListener(\'click\', function() {';
    echo             'var pid = this.getAttribute(\'data-pid\');';
    echo                'window.location.href = \'' . $url . '?pid=\' + pid;';
    echo         '});';
    echo     '});';
    echo  '});';
    echo  '</script>';
 }

 
?>



