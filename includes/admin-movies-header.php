<?php
    session_start(); //Εκκίνηση του session

    if (!isset($_SESSION['loggedin'])) { //Αν δεν έχει πραγματοποιηθεί σύνδεση χρήστη τότε πραγματοποιείται ανακατεύθυνση στο login.php
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Dashboard</title>
        <link rel="icon" type="image/png" href="../img/logo.png">
        <link rel="shortcut icon" href="../images/a-master-favicon.ico">
        <link rel="stylesheet" href="../css/admin-panel.css">
        <link rel="stylesheet" href="../css/popup-dialog.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
<body>
<div class="admin-section-header"> <!-- Div για τo header -->
        <div class="admin-logo">
            <img src="../images/logo.png" class="logo">
        </div>
        <div class="admin-login-info">
            <a href="#">Welcome, <?php echo strtolower($_SESSION['name'])?></a>
            <i class="fas fa-user" id="usericon"></i>
            
        </div>
</div>
<div class="admin-container"> <!-- Div για τα περιεχόμενα της σελίδας (κλείνει στο τέλους του movies.php) -->
    <div class="admin-section admin-section3"> <!-- Div για το side menu -->
        <ul>
            <a href="index.php"><li><i class="fas fa-sliders-h"></i>Dashboard </li></a>
            <a href="bookings.php"><li><i class="fas fa-ticket-alt"></i>Bookings</li></a>
            <a href="movies.php"><li><i class="fas fa-film"></i>Movies</li></a>                
            <a id="logout" href="logout.php"><li><i class="fas fa-sign-out-alt"></i>Logout</li></a>
        </ul>
        <script>
        $(function(){ //JQUERY που εμφανίζει μήνυμα επιβεβαίσης όταν ο χρήστης εκτελεί μία συσκεκριμένη ενέργεια (αποσύνδεση)
            $('a#logout').click(function(){
                if(confirm('Are you sure you want to logout?')) {
                    return true;
                }
                return false;
            });
        });
        </script>
    </div>