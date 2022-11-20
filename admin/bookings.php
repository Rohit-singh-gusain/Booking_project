<?php
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require '../includes/admin-movies-header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, admin-movies-header.php 

$db = new Db(); //Δημιουργία object της κλάσης Db

$allBookingsTitle = $db->get_all_bookings_and_title(); //Αποθήκευση του αποτελέσματος της function get_all_bookings_and_title της κλάσης Db στη μεταβλητή $allBookingsTitle
 
function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα και στη συνέχεια ανακατευθύνει
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'bookings.php\';</script>';
}
?>
    <div class="admin-section admin-section2" style="padding-bottom:90px;"> <!-- Div για το περιεχόμενο της σελίδας -->
        <div class="admin-section-panel admin-section-panel2"> <!-- Div που περιέχει τη φόρμα κράτησης -->
                    <div class="admin-panel-section-header">
                        <h2>Create a Booking</h2>
                    </div>
                    <form action="" method="POST" style="margin-top:15px;"> <!-- Δημιουργία φόρμας κράτησης -->                    
                        <select name="movieTitle">
                        <?php
                             
                            $result = $db->get_all_movies(); //Αποθήκευση του αποτελέσματος της function get_all_movies της κλάσης Db στη μεταβλητή $result
                            while ($row = mysqli_fetch_array($result)) {  //Όσο υπάρχουν εγγραφές, αυτές εισάγονται στη μεταβλητή $row και εμφανίζονται στα options του select field της φόρμας
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
                        ?>
        </div>
            <div class="admin-section-panel admin-section-panel1"> <!-- Div που περιέχει τα πεδία των ενεργών κρατήσεων -->
                        <div class="admin-panel-section-header">
                            <h2>Bookings</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php                            
                                if(mysqli_num_rows($allBookingsTitle) > 0){
                                    while($row = mysqli_fetch_array($allBookingsTitle)){ //Ανάθεση των περιεχωμένων της μεταβλητής $allBookingsTitle στη μεταβλητή $row και εμφάνιση των ζητούμενων αποτελεσμάτων όσο αυτή περιέχει τιμές
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
                                        echo "      <div class=\"admin-panel-section-booking-response\">\n";   //Επιλογή για διαγραφή κράτησης
                                        echo "            <a id='delbook' href='../includes/deleteBooking.php?id=".$row['bookingID']."'><i class=\"fas fa-times delete-icon\" style=\"height: 155px; line-height:150px;\" title=\"Delete booking\"></i></a>\n"; 
                                        echo "      </div>\n";
                                        echo "</div>";
                                    }
                                } else{
                                    echo '<h4 class="no-annot">No Bookings right now</h4>';
                                }   
                            $db->close(); //Τερματισμός της σύνδεσης με τη βάση                                                   
                            ?>
                        </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){ //JQUERY που εμφανίζει μήνυμα επιβεβαίσης όταν ο χρήστης εκτελεί μία συσκεκριμένη ενέργεια (διαγραφή κράτησης)
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