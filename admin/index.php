<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require '../includes/admin-header.php'; //Call the file necessary to execute the following code, admin-header.php

$db = new Db(); //Create a Db class object

$getThreeBookings = $db->get_three_bookings_and_title(); //Save the result of function get_three_bookings_and_title() of class Db to the variable $getThreeBookings
$bookings=$db->get_movies_num(); //The total number of records in function get_all_movies() in class Db is stored into the $bookings variable
$movies=$db->get_bookings_num(); //the total number of records in function get_all_bookings() in class db is stored into the $movies variable

function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'bookings.php\';</script>';
}

?>
    
    <div class="admin-section admin-section2"> <!-- Div for page content -->
        <div class="admin-section-column">
            <div class="admin-section-panel admin-section-stats"> <!-- Div for stats -->
                <div class="admin-section-stats-panel">
                    <i class="fas fa-check-square" style="background-color: #432e8d"></i>
                    <h2 style="color: #432e8d"><?php echo $bookings ?></h2> <!-- Display the set of records in the t_booking table -->
                    <h3>Bookings</h3>
                </div>
                <div class="admin-section-stats-panel">
                    <i class="fas fa-film" style="background-color: #612dca"></i>
                    <h2 style="color: #612dca"><?php echo $movies ?></h2> <!-- Display all of the records in the t_movies table -->
                    <h3>Movies</h3>
                </div>
                <div class="admin-section-stats-panel" style="padding-top:10px; cursor: pointer;" onclick="document.getElementById('popup').style.display='block'"> <!-- When the user clicks the div, javascript code runs -->
                    <i class="fas fa-book" style="background-color: #812dd6"></i>
                    <h3>Create a Booking</h3>
                    
                </div>
                <div class="admin-section-stats-panel" style="padding-top:10px; cursor: pointer; border:0;" onclick="window.location='../index.php';"> <!-- When the user clicks on the div they are redirected to the home page -->
                    <i class="fas fa-door-open" style="background-color: #b91a59"></i>
                    <h3>Visit Website</h3>
                </div>
            </div>
            <div class="admin-section-panel admin-section-panel1"> <!-- Div for bookings -->
                <div class="admin-panel-section-header">
                    <h2>Bookings</h2>
                </div>
                <div class="admin-panel-section-content">
                    <?php
                    
                        if(mysqli_num_rows($getThreeBookings) > 0){
                            while($row = mysqli_fetch_array($getThreeBookings)){ //Assigning the contents of the $getThreeBookings variable to the $row variable and displaying the requested resultsν όσο αυτή περιέχει τιμές
                                echo "<div class=\"admin-panel-section-booking-item\" style=\"margin: 10px 10px;\">\n";
                                        echo "      <div class=\"admin-panel-section-booking-info\">\n";
                                        echo "            <div>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h3>Movie: ". $row['movieTitle'] ."</h3>\n";
                                        echo "                  <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>Movie Screening Date: ". $row['bookDate'] ." ". $row['bookTime'] ."</h4>\n";
                                        echo "                  <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>Seat: ". $row['rowLetter'] ." ". $row['colNumber'] ."</h4>\n";
                                        echo "            <br><br></div>\n";
                                        echo "            <div><br><br><br>\n";
                                        echo "                   <h4>Username: ". $row['username'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Name: ". $row['firstName'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Surname: ". $row['lastName'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Phone Number: ". $row['phoneNumber'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Email: ". $row['email'] ."</h4>\n"; 
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>Booking Date: ". $row['bookTimestamp'] ."</h4>\n";
                                        echo "            </div>\n";
                                        echo "      </div>\n";
                                        echo "      <div class=\"admin-panel-section-booking-response\">\n";   //Option to delete a booking
                                        echo "            <a id='delbook' href='../includes/deleteBooking.php?id=".$row['bookingID']."'><i class=\"fas fa-times delete-icon\" style=\"height: 155px; line-height:150px;\" title=\"Delete booking\"></i></a>\n";
                                        echo "      </div>\n";
                                        echo "</div>";
                            }
                        } else{
                            echo '<h4 class="no-annot">No Bookings right now</h4>';
                        }
                    
                    ?>
                    <a href="bookings.php"><button type="submit" value="submit" name="submit" style="margin-left:25%;" class="view-all-btn">View all bookings</button></a>
                </div>                
            </div> <!-- End of div for bookings -->

                

            <div class="admin-section-panel admin-section-panel2"> <!-- Div for the movie add form -->
                <div class="admin-panel-section-header">
                    <h2>Add Movie</h2>
                </div>
                <form action="../includes/add-movie.php" method="POST" enctype="multipart/form-data"> <!-- Add a movie form -->
                    <input placeholder="Title" type="text" name="movieTitle" required>
                    <input placeholder="Description (max 500 chars)" type="text" name="movieDescription" required>
                    <input placeholder="Genre" type="text" name="movieGenre" required>
                    <input placeholder="Cast" type="text" name="movieCast" required>
                    <input placeholder="Duration (H MM)" type="text" name="movieDuration" required>
                    <input placeholder="Release Date (D MMMM YYYY)" type="text" name="movieRelDate" required>
                    <input placeholder="Seats Available" type="text" name="movieSeats" required>
                    <input placeholder="Trailer (Youtube iframe)" type="text" name="movieTrailer" required>
                    <input placeholder="Movie Path Name (''movie-name'')" type="text" name="movieLink" required>
                    <div class="upload-file">
                        
                        <label for="movieLogo">Movie Logo:</label>
                        <input type="file" name="movieLogo" id="moviebtn">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="movieCover">Movie Cover:</label>
                        <input type="file" name="movieCover" id="moviebtn">
                    </div>
                    <button type="submit" value="submit" name="submit" class="form-btn">Add Movie</button>  
                </form> <!--  End of the movie add form -->
            </div>
        </div>
    </div> <!-- End of div for page content -->

    <div id="popup" class="popup-dialog"> <!-- Div to create booking that appears when the user clicks on the div generated in line 29 -->    
        <div class="admin-section-panel admin-section-panel2 animate" style="margin:20% auto 0 auto; width:70%; height:30%;">
                    <div class="admin-panel-section-header">
                        <h2>Create Booking</h2>
                    </div>
                    <form action="" method="POST" style="margin-top:15px;">                        
                        <select name="movieTitle">
                        <?php
                           
                            $getAllMovies = $db->get_all_movies();
                            while ($row = mysqli_fetch_array($getAllMovies)) {  //As long as there are results in the $getAllMovies variable, they are stored into the $row variable and appear in the select field options of the form
                                echo "<option value=" . $row['movieTitle'] .">". $row['movieTitle'] ."</option>";
                            }
                        ?>
                        </select>                        
                        <input placeholder="Name" type="text" name="fname" class="input-fields-zindex" required>
                        <input placeholder="Surname" type="text" name="lname" class="input-fields-zindex" required>
                        <input placeholder="Email" type="text" name="email" class="input-fields-zindex" required>
                        <input placeholder="Phone Number" type="text" name="phoneNumber" class="input-fields-zindex" required>
                        <input placeholder="Date (DDDD D MMMM)" type="text" name="date" class="input-fields-zindex" required>
                        <input placeholder="Time (HH:MM)" type="text" name="hour" class="input-fields-zindex" required>
                        <input placeholder="Row Letter" type="text" name="row" class="input-fields-zindex" required>
                        <input placeholder="Line Number" type="text" name="colNumber" class="input-fields-zindex" required>          
                        <button type="submit" id="addbkngbtn" value="submit" name="submit" style="margin-top:25px;" class="form-btn">Create booking</button> 
                    </form>
        </div>
    </div>

    <?php



    if(isset($_POST['submit'])) //Check if the details have been submitted to the booking form
    {
        $movTitle = $_POST["movieTitle"]; //Assign the selected value of the above options to the variable $movieTitle
        $row2 = $db->get_movie_byTitle($movTitle);                         
                                $id = $row2['movieID']; //Assign the id of the selected record to the variable $id
                                $fname = $_POST["fname"];
                                $lname = $_POST["lname"];
                                $email = $_POST["email"];
                                $phone = $_POST["phoneNumber"];
                                $date = $_POST["date"];
                                $hour = $_POST["hour"];
                                $row = $_POST["row"];
                                $col = $_POST["colNumber"];
                                
                                $db->create_booking("$id", "$fname", "$lname", "$email", "$phone", "$date", "$hour", "$row", "$col", "admin");
                                phpAlert("Your booking for the movie " . $movTitle . " was successful!");                                        
                            }
    $db->close(); //End the connection to the database  
    ?>
    <script> //Javascript to correctly execute the display of the div generated in line 118  
    var popup = document.getElementById('popup');

    
    window.onclick = function(event) { //when it is clicked outside the div then it closes
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }

    $(function(){ //JQUERY showing confirmation message when user performs a concreted action (delete booking)
            $('a#delbook').click(function(){
                if(confirm('Are you sure you want to delete this booking?')) {
                    return true;
                }
                return false;
            });
        });
    </script>
</div>

</body>
</html>
