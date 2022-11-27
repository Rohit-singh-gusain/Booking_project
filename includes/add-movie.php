<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries

$db = new Db(); //Create a Db class object

function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
  echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'../admin/movies.php\';</script>';
}

$target1_dir = "../images/movie-logos/"; //Assign the desired path to a variable
$target2_dir = "../images/movies/";
$file1_name = basename($_FILES["movieLogo"]["name"]); //Assign the file name to a variable
$file2_name = basename($_FILES["movieCover"]["name"]);
$target_file1 = $target1_dir . basename($_FILES["movieLogo"]["name"]); //Complete desired path of the file
$target_file2 = $target2_dir . basename($_FILES["movieCover"]["name"]);
$uploadOk = 1; //Auxiliary variable that acts as a flag
$imageFile1Type = pathinfo($target_file1,PATHINFO_EXTENSION); //Assign the file information to a variable
$imageFile2Type = pathinfo($target_file2,PATHINFO_EXTENSION);

//Check if the file is a picture
if(isset($_POST["submit"])) {
  $check1 = getimagesize($_FILES["movieLogo"]["tmp_name"]);
  $check2 = getimagesize($_FILES["movieCover"]["tmp_name"]);
  if(($check1 !== false) && ($check2 !==false)) {
    $uploadOk = 1;
  } else {
    phpAlert("File(s) is(are) not an image.");
    $uploadOk = 0;
  }

  //Check if the image already exists
  if ((file_exists($target_file1)) || (file_exists($target_file2)))  {
    phpAlert("Sorry, image file already exists.");
    $uploadOk = 0;
  }

  //Check the file size
  if (($_FILES["movieLogo"]["size"] > 500000) || ($_FILES["movieCover"]["size"] > 500000))  {
    phpAlert("Sorry, your file(s) is(are) too large.");
    $uploadOk = 0;
  }

  //Check support for the file type
  if(($imageFile1Type != "jpg" && $imageFile1Type != "png" && $image1FileType != "jpeg"
  && $imageFile1Type != "gif" ) || ($imageFile2Type != "jpg" && $imageFile2Type != "png" && $image2FileType != "jpeg"
  && $imageFile2Type != "gif" )) {
    phpAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
  }

  //Check if there has been a change in the value of the auxiliary variable
  if ($uploadOk == 0) {
    phpAlert("Sorry, your image file(s) was(were) not uploaded.");
  //If the value remains the same, an attempt is made to upload the image
  } else {
    if ((move_uploaded_file($_FILES["movieLogo"]["tmp_name"], $target_file1)) && (move_uploaded_file($_FILES["movieCover"]["tmp_name"], $target_file2))) {    
      $moviepath = $_POST["movieLink"]; //Assign to the variable $moviepath the elements of the "movieLink" field of the movie insertion form
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
$db->close(); //End the connection to the database
?>
