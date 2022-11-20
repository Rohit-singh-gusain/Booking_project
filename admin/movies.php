<?php
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require '../includes/admin-movies-header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, admin-movies-header.php

$db = new Db(); //Δημιουργία object της κλάσης Db

$getAllMovies = $db->get_all_movies();

?>
    <div class="admin-section-column"> <!-- Div για το περιεχόμενο της σελίδας -->
        <div class="admin-section admin-section2">
            <div class="admin-section-panel admin-section-panel2"> <!-- Div για τη φόρμα προσθήκης ταινίας -->
                <div class="admin-panel-section-header">
                    <h2>Add a Movie</h2>
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
            
        
            <div class="admin-section-panel admin-section-panel1"> <!-- Div για τις ταινίες -->
                        <div class="admin-panel-section-header">
                            <h2>Movies</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php
                                if(mysqli_num_rows($getAllMovies) > 0){
                                    while($row = mysqli_fetch_array($getAllMovies)){ //Ανάθεση των περιεχομένων της μεταβλητής $getAllMovies στη μεταβλητή $row και εμφάνιση των ζητούμενων αποτελεσμάτων όσο αυτή περιέχει τιμές
                                        $id = $row['movieID']; //Για κάθε επανάληψη γίνεται ανάθεση του id της αντίστοιχης ταινίας στη μεταβλητή $id
                                        
                                        $bookingQuery = $db->get_max_booking_seats($id); 
                                        //Αρχικοποίηση των μεταβλητών για χρήση τους εκτός του while loop
                                        $maxsnum = "";
                                        $bkngnum = "";
                                        while($sts = mysqli_fetch_array($bookingQuery)) {  //Όσο υπάρχουν εγγραφές, αυτές εισάγονται στη μεταβλητή $row και στις μεταβλητές $maxsnum και $bkngnum
                                            $maxsnum = $sts['movieSeats'];                                              //εισάγονται ο αριθμός των θέσεων και το σύνολο των κρατήσεων αντίστοιχα
                                            $bkngnum = $sts['bookings'];
                                        }
                                        $availseats = $maxsnum - $bkngnum;  //Υπολογισμός των διαθέσιμων θέσεων και στη συνέχεια δυναμική απεικόνιση των αποτελεσμάτων του query της 4ης γραμμής
                                        echo "<div class=\"admin-panel-section-booking-item\">\n";
                                        echo "      <div class=\"admin-panel-section-booking-info\">\n";
                                        echo "            <div>\n";
                                        echo "                  <img src=". $row['movieCover'] ." style=\"width:50px;\">\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h3>". $row['movieTitle'] ."</h3>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>". $row['movieDesc'] ."</h4>\n";
                                        echo "            </div>\n";
                                        echo "            <div>\n";
                                        echo "            <br><br><br>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>Genre: ". $row['movieGenre'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                  <h4>Cast: ". $row['movieCast'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Duration: ". $row['movieDuration'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Release Date: ". $row['movieRelDate'] ."</h4>\n";
                                        echo "                   <i class=\"fab fa-gg\" style=\"color:#612dca\"></i>\n";
                                        echo "                   <h4>Available Seats: ". $availseats ."</h4>\n";
                                        echo "            </div>\n";
                                        echo "      </div>\n";
                                        echo "      <div class=\"admin-panel-section-booking-response\">\n";
                                        echo "            <a href='../includes/edit-movie.php?id=".$row['movieID']."'><i class=\"far fa-edit edit-icon\" style=\"height:95px; line-height:90px;\" title=\"Edit Movie\"></i>\n";
                                        echo "            <a id='delete' href='../includes/deleteMovies.php?id=".$row['movieID']."'><i class=\"fas fa-times delete-icon\" style=\"height:95px; line-height:90px;\" title=\"Delete Movie\"></i></a>\n";
                                        echo "      </div>\n";
                                        echo "</div>";                                  
                                    }
                                } else{
                                    echo '<h4 class="no-annot">No Movies right now</h4>';
                                }
                           
                            $db->close(); //Τερματισμός της σύνδεσης με τη βάση                    
                            ?>
                        </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){ //JQUERY που εμφανίζει μήνυμα επιβεβαίσης όταν ο χρήστης εκτελεί μία συσκεκριμένη ενέργεια (διαγραφή ταινίας)
            $('a#delete').click(function(){
                if(confirm('Are you sure you want to delete this movie?')) {
                    return true;
                }
                return false;
            });
        });
    </script>
</div>

</body>
</html>