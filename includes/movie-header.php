<?php
    session_start(); //Εκκίνηση του session
    if(isset($_SESSION['login']))  //Αν έχει πραγματοποιηθεί σύνδεση χρήστη τότε το username του εισάγεται στη μεταβλητή $username
    {
        $username = $_SESSION['login'];
    }
    else //Αν δεν έχει πραγματοποιηθεί σύνδεση χρήστη τότε το username "guest" εισάγεται στη μεταβλητή $username
    {
        $username = "guest";
    }
    $_SESSION['currenturl'] = $_SERVER['REQUEST_URI']; //Πραγματοποιείται αίτημα στον server για να επιστρέψει το link της σελίδας, το οποίο εισάγεται στη μεταβλητή $_SESSION['currenturl'];
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PHPFLIX - Book your ticket now!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/a-master-favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   </head>
<body>
<div class="wrapper-parallax"> <!-- Div που εξυπηρετεί στο parallax effect του περιεχομένου και του footer (κλείνει στο footer.php) -->
    <div class="content">      <!-- Div που περιέχει όλο το περιεχόμενο της σελίδας (κλείνει στο movie-footer.php) -->
<div class="header" id="header">
    <a class="logo" href="../home.php"><img src="../images/logo-small.png" alt="logo"></a> <!-- Εισαγωγή του logo -->
    <nav> <!-- Δημιουργία του nav bar -->
    <ul class="nav-ul" id="nav-ul">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php#gotomovies">Movies</a></li>
            <?php if(isset($_SESSION['login'])){ echo '<li><a href="../booking-history.php">Booking History</a></li>'; }?>  <!-- Έλεγχος αν υπάρχει συνδεμένος χρήστης και αν ναι τότε να εμφανίζει στο μενού την επιλογή "Booking History" -->
            <li><a href="../about-us.php">About Us</a></li>         
            <?php 
            if(!isset($_SESSION['login'])){ //Έλεγχος αν υπάρχει συνδεμένος χρήστης και εμφάνιση κατάλληλης επιλογής στο μενού" 
                echo '<li><a class="cta" href="../login.php">Account</a></li>';
            } else {
                echo '<li><a class="cta" id="logout" href="../includes/logout.php">Logout</a></li>';
            }
            ?>
        </ul>
        <button class="hamburger" id="hamburger"> <!-- Κουμπί μενού που εμφανίζεται υπό κατάλληλες προϋποθέσεις (μικρότερο breakpoint) -->
        <i class="fas fa-bars"></i>
        </button>
    </nav>
</div>
<script src="/phpflix/scripts/mobmenu.js"></script> <!-- Javascript για τη σωστή λειτουργία του παραπάνω κουμπιού μενού -->

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

