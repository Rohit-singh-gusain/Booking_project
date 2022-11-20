<?php 
require 'database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require 'includes/booking-about-header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, booking-about-header.php 

$db = new Db(); //Δημιουργία object της κλάσης Db

if(!isset($_SESSION['login'])) //Έλεγχος αν υπάρχει συνδεμένος χρήστης. Αν δεν υπάρχει, τότε γίνεται ανακατεύθυνση στην αρχική σελίδα.
{
    header('Location: home.php');
}

$userBookings = $db->get_user_bookings($username);  //Αποθήκευση του αποτελέσματος της function get_user_bookings της κλάσης Db στη μεταβλητή $userBookings
                                                    //Η μεταβλητή $username δημιουργήθηκε στο booking-about-header.php
                                                                                                                                                       
?>                                                                                                                                                      

    <div class="admin-section admin-section2"> <!-- Div με τα περιεχόμενα του booking history για τον συνδεμένο χρήστη -->
        <div class="admin-section-column">
            <div class="admin-section-panel admin-section-panel1">
                        <div class="admin-panel-section-header">
                            <h2>Booking History</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php
                                if(mysqli_num_rows($userBookings) > 0){
                                    while($row = mysqli_fetch_array($userBookings)){ //Για όσο υπάρχουν αποθηκευμένα δεδομένα στη μεταβλητή $userBookings, αυτά να εμφανίζονται παρακάτω δυναμικά από τη βάση
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
<?php require 'includes/footer.php' ?> <!-- Κλήση του απαραίτητου για την εκτέλεση του παραπάνω κώδικα αρχείου, footer.php -->