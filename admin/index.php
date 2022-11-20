<?php
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require '../includes/admin-header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, header.php

$db = new Db(); //Δημιουργία object της κλάσης Db

$getThreeBookings = $db->get_three_bookings_and_title(); //Αποθήκευση του αποτελέσματος της function get_three_bookings_and_title() της κλάσης Db στη μεταβλητή $getThreeBookings
$bookings=$db->get_movies_num(); //O συνολικός αριθμός των εγγραφών της function get_all_movies() της κλάσης Db  εισάγεται στη μεταβλητή $bookings
$movies=$db->get_bookings_num(); //O συνολικός αριθμός των εγγραφών της function get_all_bookings() της κλάσης Db  εισάγεται στη μεταβλητή $movies

function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα και στη συνέχεια ανακατευθύνει
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'bookings.php\';</script>';
}

?>
    
    <div class="admin-section admin-section2"> <!-- Div για το περιεχόμενο της σελίδας -->
        <div class="admin-section-column">
            <div class="admin-section-panel admin-section-stats"> <!-- Div για τα στατιστικά -->
                <div class="admin-section-stats-panel">
                    <i class="fas fa-check-square" style="background-color: #432e8d"></i>
                    <h2 style="color: #432e8d"><?php echo $bookings ?></h2> <!-- Εμφάνιση των συνόλου των εγγραφών του πίνακα t_booking -->
                    <h3>Bookings</h3>
                </div>
                <div class="admin-section-stats-panel">
                    <i class="fas fa-film" style="background-color: #612dca"></i>
                    <h2 style="color: #612dca"><?php echo $movies ?></h2> <!-- Εμφάνιση των συνόλου των εγγραφών του πίνακα t_movies -->
                    <h3>Movies</h3>
                </div>
                <div class="admin-section-stats-panel" style="padding-top:10px; cursor: pointer;" onclick="document.getElementById('popup').style.display='block'"> <!-- Όταν ο χρήστης κάνει κλικ στο div εκτελείται κώδικας javascript -->
                    <i class="fas fa-book" style="background-color: #812dd6"></i>
                    <h3>Create a Booking</h3>
                    
                </div>
                <div class="admin-section-stats-panel" style="padding-top:10px; cursor: pointer; border:0;" onclick="window.location='../index.php';"> <!-- Όταν ο χρήστης κάνει κλικ στο div ανακατευθύνεται στην αρχική σελίδα -->
                    <i class="fas fa-door-open" style="background-color: #b91a59"></i>
                    <h3>Visit Website</h3>
                </div>
            </div>
            <div class="admin-section-panel admin-section-panel1"> <!-- Div για τα bookings -->
                <div class="admin-panel-section-header">
                    <h2>Bookings</h2>
                </div>
                <div class="admin-panel-section-content">
                    <?php
                    
                        if(mysqli_num_rows($getThreeBookings) > 0){
                            while($row = mysqli_fetch_array($getThreeBookings)){ //Ανάθεση των περιεχωμένων της μεταβλητής $getThreeBookings στη μεταβλητή $row και εμφάνιση των ζητούμενων αποτελεσμάτων όσο αυτή περιέχει τιμές
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
                                        echo "      <div class=\"admin-panel-section-booking-response\">\n";   //Επιλογή για διαγραφή κράτησης
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
            </div> <!--  Τέλος div για τα bookings -->

                

            <div class="admin-section-panel admin-section-panel2"> <!-- Div για τη φόρμα προσθήκης ταινίας -->
                <div class="admin-panel-section-header">
                    <h2>Add Movie</h2>
                </div>
                <form action="../includes/add-movie.php" method="POST" enctype="multipart/form-data"> <!-- Φόρμα προσθήκης ταινίας -->
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
                </form> <!--  Τέλος φόρμας προσθήκης ταινίας -->
            </div>
        </div>
    </div> <!-- Κλείσιμο div για το περιεχόμενο της σελίδας -->

    <div id="popup" class="popup-dialog"> <!-- Div για τη δημιουργία κράτησης που εμφανίζεται όταν ο χρήστης κάνει κλικ στο div που δημιουργείται στη γραμμή 29 -->    
        <div class="admin-section-panel admin-section-panel2 animate" style="margin:20% auto 0 auto; width:70%; height:30%;">
                    <div class="admin-panel-section-header">
                        <h2>Create Booking</h2>
                    </div>
                    <form action="" method="POST" style="margin-top:15px;">                        
                        <select name="movieTitle">
                        <?php
                           
                            $getAllMovies = $db->get_all_movies();
                            while ($row = mysqli_fetch_array($getAllMovies)) {  //Όσο υπάρχουν αποτελέσματα στη μεταβλητή $getAllMovies, αυτά εισάγονται στη μεταβλητή $row και εμφανίζονται στα options του select field της φόρμας
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



    if(isset($_POST['submit'])) //Έλεγχος αν έχει γίνει υποβολή των στοιχείων στη φόρμα κράτησης
    {
        $movTitle = $_POST["movieTitle"]; //Ανάθεση της επιλεγμένης τιμής (value) των παραπάνω options στη μεταβλητή $movieTitle
        $row2 = $db->get_movie_byTitle($movTitle);                         
                                $id = $row2['movieID']; //Ανάθεση του id της επιλεγμένης εγγραφής στη μεταβλητή $id
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
    $db->close(); //Τερματισμός της σύνδεσης με τη βάση   
    ?>
    <script> //Javascript για τη σωστή εκτέλεση της εμφάνισης του div που δημιουργείται στη γραμμή 118   
    var popup = document.getElementById('popup');

    
    window.onclick = function(event) { // Όταν γίνει κλικ εκτός του div τότε αυτό κλείνει
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }

    $(function(){ //JQUERY που εμφανίζει μήνυμα επιβεβαίσης όταν ο χρήστης εκτελεί μία συσκεκριμένη ενέργεια (αποσύνδεση)
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