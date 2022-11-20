<?php
session_start(); //Εκκίνηση του session
session_destroy(); //Κατάργηση του sesssion

header('Location: login.php'); //Ανακατεύθυνση στο login.php
?>