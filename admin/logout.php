<?php
session_start(); //Start the session
session_destroy(); //Remove sesssion

header('Location: login.php'); //Redirect to login.php
?>
