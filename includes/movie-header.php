<?php
    session_start(); //Start the session
    if(isset($_SESSION['login']))  //If a user login has been made then his username is entered in the variable $username
    {
        $username = $_SESSION['login'];
    }
    else //If no user login has been established then the username "guest" is entered in the variable $username
    {
        $username = "guest";
    }
    $_SESSION['currenturl'] = $_SERVER['REQUEST_URI']; //Is a request made to the server to return the page link, which is inserted in the variable $_SESSION['currenturl']?
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
<div class="wrapper-parallax"> <!-- Div serving in the parallax effect of content and footer (closes the footer.php) -->
    <div class="content">      <!-- Div containing all page content (closes the movie-footer.php) -->
<div class="header" id="header">
    <a class="logo" href="../home.php"><img src="../images/logo-small.png" alt="logo"></a> <!-- Logo -->
    <nav> <!-- Create the nav bar -->
    <ul class="nav-ul" id="nav-ul">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php#gotomovies">Movies</a></li>
            <?php if(isset($_SESSION['login'])){ echo '<li><a href="../booking-history.php">Booking History</a></li>'; }?>  <!-- Check if there is a logged-in user and if so then display in the menu the option "Booking History" -->
            <li><a href="../about-us.php">About Us</a></li>         
            <?php 
            if(!isset($_SESSION['login'])){ //Check if there is a logged-in user and display a suitable option in the menu 
                echo '<li><a class="cta" href="../login.php">Account</a></li>';
            } else {
                echo '<li><a class="cta" id="logout" href="../includes/logout.php">Logout</a></li>';
            }
            ?>
        </ul>
        <button class="hamburger" id="hamburger"> <!-- Menu button displayed under appropriate conditions (smaller breakpoint) -->
        <i class="fas fa-bars"></i>
        </button>
    </nav>
</div>
<script src="/phpflix/scripts/mobmenu.js"></script> <!-- Javascript for the proper functioning of the above menu button -->

<script>
    $(function(){ //JQUERY showing confirmation message when user performs a concreted action (logout)
        $('a#logout').click(function(){
            if(confirm('Are you sure you want to logout?')) {
                return true;
            }
            return false;
        });
    });
</script>

