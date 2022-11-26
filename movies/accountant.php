<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require '../includes/movie-header.php'; //Call the file necessary to execute the following code, movie-header.php

$db = new Db(); //Create a Db class object

$row = $db->get_movie(9); //Save the result of function get_movie of the DB class to the variable $row

function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
echo '<script type="text/javascript">alert("' . $msg . '");window.location = "' . $_SESSION['currenturl'] .'";</script>';
}
?>

<div class="container"> <!-- Div for page content -->
  <div class="content-container"> <!-- Container div for movie information -->
    <?php echo '<div class="movie-page-content text-left" style="background: linear-gradient(to bottom, rgba(0,0,0,0), #151515), url('.$row['movieCover'].') no-repeat center center fixed; background-size: cover;">'; 
        echo '<img class="movie-logo" src="'.$row['movieLogo'].'" style="margin-top:260px;">'; ?>
        <p class="movie-desc" style="margin-top:20px;"><?php echo $row['movieDesc'];?></p>            
        <br><br>
        <p class="movie-desc">Genre: <?php echo $row['movieGenre'];?>  </p>
        <br><br>
        <p class="movie-desc">Cast: <?php echo $row['movieCast'];?>   </p> 
        <br><br>  
        <p class="movie-desc">Duration: <?php echo $row['movieDuration'];?> &nbsp;&nbsp; Release Date: <?php echo $row['movieRelDate'];?> </p>  
               </div>
  </div> <!-- End of the container div-->
    <br>
    <div class="trailer-container"> <!-- Div for the movie trailer -->
        <?php echo $row['movieTrailer'];?>
    </div> <!-- End of the trailer div -->

  <?php 
    $id = $row['movieID'];    
    $bookingQuery = $db->get_max_booking_seats($id); //Save the result of function get_max_booking_seats of the DB class to the variable $bookingQuery
    $maxsnum = "";
    $bkngnum = "";
    while($sts = mysqli_fetch_array($bookingQuery)) {
      $maxsnum = $sts['movieSeats'];
      $bkngnum = $sts['bookings'];
    }
    $seats = $maxsnum - $bkngnum; //Calculation of available seats
  ?>

  <div class="form-container"> <!-- Container div of the booking form -->
    <div class="container-form">
      <form action="" method="POST">  <!-- Creation of the form -->
        <h2>Book your ticket for <?php echo $row['movieTitle'];?>!</h2>
        <?php 
        if($seats != 0) { //Check if the available positions are not 0 if they are then the form content is not displayed
          if(!isset($_SESSION['login'])){ //Check if there is no logged-in user, if any, show specific fields
            echo '<div class="form-field">';
            echo '<p>Name</p>';
            echo '<input type="text" name="fname" placeholder="Your Name" title="Must contain only letters" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Surname</p>';
            echo '<input type="text" name="lname" placeholder="Your Surname" title="Must contain only letters" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Email</p>';
            echo '<input type="email" name="email" placeholder="Your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Phone Number&nbsp;&nbsp;</p>';
            echo '<input type="phone" name="phone" pattern="[0-9]{10}" placeholder="Your phone number" required>';
            echo '</div>';
          } 
          echo '<div class="form-field">';
          echo '<p>Date</p>';
          echo '<select name="date" required>';
          echo '<option value="" disabled selected>Date</option>';
          echo '<option value="Monday 1 June">Monday 1 June</option>';
          echo '<option value="Tuesday 2 June">Tuesday 2 June</option>';
          echo '<option value="Wednesday 3 June">Wednesday 3 June</option>';
          echo '<option value="Thursday 4 June">Thursday 4 June</option>';
          echo '<option value="Friday 5 June">Friday 5 June</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Time</p>';
          echo '<select name="hour" required>';
          echo '<option value="" disabled selected>Time</option>';
          echo '<option value="15:00">15:00</option>';
          echo '<option value="18:00">18:00</option>';
          echo '<option value="21:00">21:00</option>';
          echo '<option value="23:00">23:00</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Row</p>';
          echo '<select name="row" required>';
          echo '<option value="" disabled selected>Row</option>';
          echo '<option value="Row A">A</option>';
          echo '<option value="Row B">B</option>';
          echo '<option value="Row C">C</option>';
          echo '<option value="Row D">D</option>';
          echo '<option value="Row E">E</option>';
          echo '<option value="Row F">F</option>';
          echo '<option value="Row G">G</option>';
          echo '<option value="Row H">H</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Column</p>';
          echo '<select name="colNumber" required>';
          echo '<option value="" disabled selected>Column</option>';
          echo '<option value="Number 1">1</option>';
          echo '<option value="Number 2">2</option>';
          echo '<option value="Number 3">3</option>';
          echo '<option value="Number 4">4</option>';
          echo '<option value="Number 5">5</option>';
          echo '<option value="Number 6">6</option>';
          echo '<option value="Number 7">7</option>';
          echo '<option value="Number 8">8</option>';
          echo '<option value="Number 9">9</option>';
          echo '<option value="Number 10">10</option>';
          echo '</select>';
          echo '</div>';
          echo '<button type="submit" name="submit" value="submit" class="btn">Submit</button>';
        }
        ?>     
        <p id="seats"></p>      
      </form> <!-- End of the form div -->
            <script> //Javascript code that displays a text and the value of the variable $seats in the <p> tag with id="seats"       
              document.getElementById("seats").innerHTML = "<?php echo "Available seats: " . $seats?>";
            </script>
    </div>   
    <div class="container-time"><img src="../images/cinema-seats.png" style="width: 90%; height:750px;"></div> <!-- Div containing an image with the cinema seats -->
  </div>    

  <?php 
  if(isset($_SESSION['login'])){ //Check if there is a logged-in userς
   
    $username = $_SESSION['login']; //Save the logged-in username to the variable $username
    $row2 = $db->get_username($username); //Save the result of function get_username of the DB class in the $row2 variable

    $fname = $row2['firstName'];  //Store information from the database up in the corresponding variables
    $lname = $row2['lastName'];
    $email = $row2['email'];
    $phone = $row2['phoneNumber'];
  } else {                      //if there is no logged-in user then the variables store the contents of the booking form fields
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
  }
  $movieTitle = $row['movieTitle'];
  $movieID = $row['movieID'];
  $date = $_POST["date"];
  $hour = $_POST["hour"];
  $row = $_POST["row"];
  $col = $_POST["colNumber"];
 

  if(isset($_POST['submit']))  //Check if the submit button has been pressed by the user and run the function create_booking of the DB class in the database
  {
    $db->create_booking("$movieID", "$fname", "$lname", "$email", "$phone", "$date", "$hour", "$row", "$col", "$username");
    phpAlert("Your booking for the movie " . $movieTitle . " was successful!"); //Successful booking message ς                    
  }
echo '</div>'; //End of the div for page content
require '../includes/movie-footer.php'; //Call the file necessary to execute the above code, movie-footer.php 
?>
