<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../dbconnect.inc.php');


$select_data = $db->prepare("SELECT * FROM Messages WHERE ID=:id");
// $select_data->bindValue(':id', '1');

$daten = array(
    "id" => $_GET['ID'],
    // "id" => 1,
);

$select_data->execute($daten);

// Fehlerüberprüfung
if ($select_data == false) {
    $fehler = $db->errorInfo();
    die("Folgender Datenbankfehler ist aufgetreten: " . $fehler[2]);
}

$data = $select_data->fetchAll();

header('Content-Type: application/json');
echo json_encode($data);


?>