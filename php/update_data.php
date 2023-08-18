<?php

// Debug stuff
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);

// import database connection file
require_once('../dbconnect.inc.php');


$channel_ID = $_POST['ID'];

// check if post variables are set and build dynamic sql query with them
if (isset($_POST) && !empty($_POST)) {
    $sql = "UPDATE Messages SET ";
    $post_var_counter = 0;
    foreach($_POST as $key => $value) {
        if ($key !== 'ID') {
            $sql .= "$key=:$key";
            // don't set a comma if it's only one variable and if it's the last variable
            if (count($_POST) !== 1 && $post_var_counter !== count($_POST) - 2) {
                $sql .= ", ";
            }
            $post_var_counter += 1;
        }
    }
    $sql .= " WHERE ID=$channel_ID";

    // echo "<br><br>$sql<br><br>";

    // prepare sql query
    $update_query = $db->prepare($sql);

    // fill values in sql query
    foreach($_POST as $key => $value) {
        if ($key !== 'ID') {
            $update_query->bindParam(":$key", $_POST[$key]);
        }
    }

    // execute query
    $update_query->execute();
}



?>