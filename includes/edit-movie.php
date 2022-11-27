<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require 'admin-header.php'; //Call the file necessary to execute the following code, admin-header.php 

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
$path1="../images/movie-logos/".$file2_name."";
$path2="../images/movies/".$file1_name."";

$id = $_REQUEST['id']; //Assign to the variable $id the contents of the "id" sent through the "GET" method to the url

$row = $db->get_movie($id); //Save the result of function get_movie of the DB class to the variable $row

//Assign the query result to the following variables
$title = $row['movieTitle']; 
$genre = $row['movieGenre'];					
$duration = $row['movieDuration'];
$reldate = $row['movieRelDate'];
$desc = $row['movieDesc'];
$cast = $row['movieCast'];					
$trailer = $row['movieTrailer'];
$seats = $row['movieSeats'];
$link = $row['movieLink'];


if(isset($_POST["submit"])) { //Check if the items in the movie edit form have been submitted
 
  //assign the values of the form fields to the following variables
  $title_new = $_POST["movieTitle"];
  $genre_new = $_POST["movieGenre"];
  $dur_new = $_POST["movieDuration"];
  $reldate_new = $_POST["movieRelDate"];
  $desc_new = $_POST["movieDescription"];
  $cast_new = $_POST["movieCast"];
  $trailer_new = $_POST["movieTrailer"];
  $seats_new = $_POST["movieSeats"];
  $moviepath = $_POST["movieLink"];

  //Check if the file is a picture
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

      $db->update_movie($target_file2, $target_file1, $title_new, $genre_new, $dur_new, $reldate_new, $desc_new, $cast_new, $trailer_new, $seats_new, $moviepath, $id);
      phpAlert("The movie ". $_POST["movieTitle"]. " has been updated.");
      
    } else {
      phpAlert("Sorry, there was an error updating your movie.");
    }
  }
}
?>
<div class="admin-section-column" style="margin: 10px 10px;"> <!-- Div containing the movie edit form -->
  <div class="admin-section-panel admin-section-panel2">
    <div class="admin-panel-section-header">
        <h2>Edit Movie: <?php echo $row['movieTitle'] ?></h2>
    </div>    
    <form action method="POST" style="margin-top:15px;" enctype="multipart/form-data"> <!-- Selected movie edit form -->
    <input placeholder="Title" type="text" name="movieTitle" value="<?php echo $title ?>" required>
    <input placeholder="Description (max 500 chars)" type="text" value="<?php echo $desc ?>" name="movieDescription"  required>
    <input placeholder="Genre" type="text" name="movieGenre" value="<?php echo $genre ?>" required>
    <input placeholder="Cast" type="text" name="movieCast" value="<?php echo $cast ?>" required>
    <input placeholder="Duration (H MM)" type="text" name="movieDuration" value="<?php echo $duration ?>" required>
    <input placeholder="Release Date (D MMMM YYYY)" type="text" name="movieRelDate" value="<?php echo $reldate ?>" required>
    <input placeholder="Seats Available" type="text" name="movieSeats" value="<?php echo $seats ?>" required>
    <input placeholder="Trailer (Youtube iframe)" type="text" name="movieTrailer" required>
    <input placeholder="Movie Path Name (''movie-name'')" type="text" name="movieLink" value="<?php echo $link ?>" required>
    <div class="upload-file">                    
        <label for="movieLogo">Movie Logo:</label>
        <input type="file" name="movieLogo" id="moviebtn">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="movieCover">Movie Cover:</label>
        <input type="file" name="movieCover" id="moviebtn">
    </div>
    <button type="submit" value="submit" name="submit" class="form-btn">Save</button>  
    </form>
  </div>
</div>
<?php $db->close(); //End the connection to the database
?>
</body>
</html>
