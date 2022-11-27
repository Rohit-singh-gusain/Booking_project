<?php
session_start(); //Start the session
session_destroy(); //Remove sesssion

header('Location: ' . $_SESSION['currenturl'] ); //Redirect to previous page
?>
