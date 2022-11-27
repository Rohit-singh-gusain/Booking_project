<?php 
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries

$db = new Db();

$id = $_GET['id']; //Store in the variable $id the contents of the "id" sent through the "GET" method in the url

if ($db->delete_booking($id)) { //if the function is executed then the specified address is redirected otherwise an error message is displayed
    header('Location: ../admin/bookings.php');
    exit;
} 
?>
