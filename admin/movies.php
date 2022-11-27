<?php
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require '../includes/admin-movies-header.php'; //Call the file necessary to execute the following code, admin-movies-header.php

$db = new Db(); //Create a Db class object

$getAllMovies = $db->get_all_movies();

?>
    <div class="admin-section-column"> <!-- Div for page content -->
        <div class="admin-section admin-section2">
            <div class="admin-section-panel admin-section-panel2"> <!-- Div for the movie add form -->
                <div class="admin-panel-section-header">
                    <h2>Add a Movie</h2>
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
            
        
            <div class="admin-section-panel admin-section-panel1"> <!-- Div for the movies -->
                        <div class="admin-panel-section-header">
                            <h2>Movies</h2>
                        </div>
                        <div class="admin-panel-section-content">
                            <?php
                                if(mysqli_num_rows($getAllMovies) > 0){
                                    while($row = mysqli_fetch_array($getAllMovies)){ //Assign the contents of the $getAllMovies variable to the $row variable and display the requested results as long as it contains values
                                        $id = $row['movieID']; //Each iteration assigns the id of the corresponding movie to the variable $id
                                        
                                        $bookingQuery = $db->get_max_booking_seats($id); 
                                        //Initialization of variables for use outside the while loop
                                        $maxsnum = "";
                                        $bkngnum = "";
                                        while($sts = mysqli_fetch_array($bookingQuery)) {  //As long as there are records, they are entered into the $row variable and $maxsnum variables, and $bkngnum
                                            $maxsnum = $sts['movieSeats'];                 //the number of seats and the total reservations respectively are entered
                                            $bkngnum = $sts['bookings'];
                                        }
                                        $availseats = $maxsnum - $bkngnum;  //Calculate available seats and then dynamically display the results of the 4th line query
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
                           
                            $db->close(); //End the connection to the database                    
                            ?>
                        </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){ //JQUERY showing confirmation message when user performs a confused action (delete movie)
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
