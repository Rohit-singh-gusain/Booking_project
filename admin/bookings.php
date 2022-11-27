<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require '../includes/admin-movies-header.php'; //Call the file necessary to execute the following code, admin-header.php

$db = new Db(); //Create a Db class object

$allBookingsTitle = $db->get_all_bookings_and_title(); //Save the result of function get_all_bookings_and_title of the DB class in the variable $allBookingsTitle
 
function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'bookings.php\';</script>';
}
?>
    <div class="admin-section admin-section2" style="padding-bottom:90px;"> <!-- Div for page content -->
        <div class="admin-section-panel admin-section-panel2"> <!-- Div containing the booking form -->
                    <div class="admin-panel-section-header">
                        <h2>Create a Booking</h2>
                    </div>
                    <form action="" method="POST" style="margin-top:15px;"> <!-- Create the booking form -->                    
                        <select name="movieTitle">
                        <?php                             
                            $result = $db->get_all_movies(); //Save the result of function get_all_movies of the DB class in the $result variable
                            while ($row = mysqli_fetch_array($result)) {  //As long as records exist, they are stored into the $row variable and appear in the select field options of the form
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
                        <button type="submit" value="submit" name="submit" style="margin-top:25px;" class="form-btn">Create booking</button> 
                    </form>
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
                        ?>
        </div>
            <div class="admin-section-panel admin-section-panel1"> <!-- Div containing the fields of active bookings -->
                        <div class="admin-panel-section-header">
                            <h2>Bookings</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php                            
                                if(mysqli_num_rows($allBookingsTitle) > 0){
                                    while($row = mysqli_fetch_array($allBookingsTitle)){ //Assign the contents of the $allBookingsTitle variable to the $row variable and display the requested results as long as it contains values
                                        echo "<div class=\"admin-panel-section-booking-item\"  style=\"margin: 10px 10px;\">\n";
                                        echo "      <div class=\"admin-panel-section-booking-info\">\n";
                                        echo "            <div>\n";
                                        echo "                  <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
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
                            $db->close(); //End the connection to the database                                                 
                            ?>
                        </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){ //JQUERY showing confirmation message when user performs a specific action (delete booking)
            $('a#delbook').click(function(){
                if(confirm('Are you sure you want to delete this booking?')) {
                    return true;
                }
                return false;
            });
        });
    </script>

</body>
</html>
