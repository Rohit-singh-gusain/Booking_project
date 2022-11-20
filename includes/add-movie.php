<?php
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php

$db = new Db(); //Δημιουργία object της κλάσης Db

function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα και στη συνέχεια ανακατευθύνει
  echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'../admin/movies.php\';</script>';
}

$target1_dir = "../images/movie-logos/"; //Ανάθεση του επιθυμητού path σε μεταβλητή
$target2_dir = "../images/movies/";
$file1_name = basename($_FILES["movieLogo"]["name"]); //Ανάθεση του ονόματος του αρχείου σε μεταβλητή
$file2_name = basename($_FILES["movieCover"]["name"]);
$target_file1 = $target1_dir . basename($_FILES["movieLogo"]["name"]); //Ολοκληρωμένο επιθυμητό path του αρχείου 
$target_file2 = $target2_dir . basename($_FILES["movieCover"]["name"]);
$uploadOk = 1; //Βοηθητική μεταβλητή που λειτουργεί ως flag
$imageFile1Type = pathinfo($target_file1,PATHINFO_EXTENSION); //Ανάθεση των πληροφοριών του αρχείου σε μεταβλητή
$imageFile2Type = pathinfo($target_file2,PATHINFO_EXTENSION);

//Έλεγχος αν το αρχείο είναι εικόνα
if(isset($_POST["submit"])) {
  $check1 = getimagesize($_FILES["movieLogo"]["tmp_name"]);
  $check2 = getimagesize($_FILES["movieCover"]["tmp_name"]);
  if(($check1 !== false) && ($check2 !==false)) {
    $uploadOk = 1;
  } else {
    phpAlert("File(s) is(are) not an image.");
    $uploadOk = 0;
  }

  //Έλεγχος αν η εικόνα υπάρχει ήδη
  if ((file_exists($target_file1)) || (file_exists($target_file2)))  {
    phpAlert("Sorry, image file already exists.");
    $uploadOk = 0;
  }

  //Έλεγχος του μεγέθους του αρχείου
  if (($_FILES["movieLogo"]["size"] > 500000) || ($_FILES["movieCover"]["size"] > 500000))  {
    phpAlert("Sorry, your file(s) is(are) too large.");
    $uploadOk = 0;
  }

  //Έλεγχος υποστήριξης του τύπου του αρχείου
  if(($imageFile1Type != "jpg" && $imageFile1Type != "png" && $image1FileType != "jpeg"
  && $imageFile1Type != "gif" ) || ($imageFile2Type != "jpg" && $imageFile2Type != "png" && $image2FileType != "jpeg"
  && $imageFile2Type != "gif" )) {
    phpAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
  }

  //Έλεγχος αν έχει υπάρξει αλλαγή στη τιμή της βοηθητικής μεταβλητής
  if ($uploadOk == 0) {
    phpAlert("Sorry, your image file(s) was(were) not uploaded.");
  //Αν η τιμή έχει παραμείνει ίδια, γίνεται προσπάθεια μεταφόρτωσης της εικόνας
  } else {
    if ((move_uploaded_file($_FILES["movieLogo"]["tmp_name"], $target_file1)) && (move_uploaded_file($_FILES["movieCover"]["tmp_name"], $target_file2))) {    
      $moviepath = $_POST["movieLink"]; //Ανάθεση στη μεταβλητή $moviepath τα στοιχεία του πεδίου "movieLink" της φόρμας εισαγωγής ταινίας
      $movieTitle = $_POST["movieTitle"];
      $movieGenre = $_POST["movieGenre"];
      $movieDuration = $_POST["movieDuration"];
      $movieRelDate = $_POST["movieRelDate"];
      $movieDesc = $_POST["movieDescription"];
      $movieCast = $_POST["movieCast"];
      $movieTrailer = $_POST["movieTrailer"];
      $movieSeats = $_POST["movieSeats"];
     
        $db->add_movie("$target_file2", "$target_file1", "$movieTitle", "$movieGenre", "$movieDuration", "$movieRelDate", "$movieDesc", "$movieCast", "$movieTrailer", "$movieSeats", "$moviepath"); 
        phpAlert("The movie ". $_POST["movieTitle"]. " has been added to the database.");
      
      } else {
        phpAlert("Sorry, there was an error inserting your movie.");
      }
    }
}
$db->close(); //Τερματισμός της σύνδεσης με τη βάση
?>