<?php
session_start(); //Εκκίνηση του session
session_destroy(); //Κατάργηση του sesssion

header('Location: ' . $_SESSION['currenturl'] ); //Ανακατεύθυνση στη προηγούμενη σελίδα
?>