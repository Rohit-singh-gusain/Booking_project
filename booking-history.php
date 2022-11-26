<?php 
require 'database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require 'includes/booking-about-header.php'; //Call the file necessary to execute the following code, booking-about-header.php 

$db = new Db(); //Create a Db class object

if(!isset($_SESSION['login'])) //Check if there is a logged-in user. if it does not exist then redirect to the homepage 
{
    header('Location: home.php');
}

$userBookings = $db->get_user_bookings($username);  //Save the result of function get_user_bookings of the DB class in the $userBookings variable
                                                    //The variable $username was created in booking-about-header.php
                                                                                                                                                       
?>                                                                                                                                                      

    <div class="admin-section admin-section2"> <!-- Div with the contents of the booking history for the logged-in user -->
        <div class="admin-section-column">
            <div class="admin-section-panel admin-section-panel1">
                        <div class="admin-panel-section-header">
                            <h2>Booking History</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php
                                if(mysqli_num_rows($userBookings) > 0){
                                    while($row = mysqli_fetch_array($userBookings)){ //For as long as data is stored in the $userBookings variable, display it below dynamically from the database
                                        echo "<div class=\"admin-panel-section-booking-item\">\n";
                                        echo "      <div class=\"admin-panel-section-booking-info\">\n";
                                        echo "            <div>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h3>Movie Title:</h3><h4> ". $row['movieTitle'] ."</h4>\n";
                                        echo "                  <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h3>Movie Screening Date:</h3><h4> ". $row['bookDate'] ." ". $row['bookTime'] ."</h4>\n";
                                        echo "                  <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h3>Seat:</h3><h4> ". $row['rowLetter'] ." ". $row['colNumber'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h3>Booking Date:</h3><h4> ". $row['bookTimestamp'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "            </div>\n";
                                        echo "      </div>\n";
                                        echo "</div>";
                                    }
                                } else{
                                    echo '<h4 class="no-annot">No Bookings right now</h4>';
                                }                        
                            ?>
                        </div>
            </div>
        </div>
    </div>
</div>
<?php require 'includes/footer.php' ?> <!-- Call the file necessary to execute the above code, footer.php -->
