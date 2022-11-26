<?php 
require 'database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries
require 'includes/header.php'; //Call the file necessary to execute the following code, header.php

$db = new Db(); //Create a Db class object

$trend1 = $db->get_movie(5); //Save the result of function get_movie of the DB class in the $trend1 variable
$trend1Cover = substr($trend1['movieCover'],3); //Using the "substr" method as, the movie Cover value in the database starts with ".. /"

$trend2 = $db->get_movie(6); //Save the result of function get_movie of the DB class in the $trend2 variable
$trend2Cover = substr($trend2['movieCover'],3); 

$trend3 = $db->get_movie(8); //Save the result of function get_movie of the DB class in the $trend3 variable
$trend3Cover = substr($trend3['movieCover'],3); 

$movcol1sql = $db->get_home_movies_col1(); //Save the result of function get_home_movies_col1 of the DB class in the $movcol1sql variable
$movcol2sql = $db->get_home_movies_col2(); //Save the result of function get_home_movies_col2 of the DB class in the $movcol2sql variable

?>

    <div class="container trending-movies">  <!-- Div for the trending slider -->
        <h1>Trending Movies&#128293;</h1>
        <br>
        <div class="slideshow-container">
            <div class="mySlides">
                <div class="row">
                    <div class="col-md-6 left-box">
                        <h2><?php echo $trend1['movieTitle']; ?></h2> <!-- Display the movie title dynamically from the database-->
                        <p><?php echo $trend1['movieDesc']; ?></p> <!-- Display the movie description dynamically from the database -->
                        <p>Genre: <?php echo $trend1['movieGenre']; ?></p> <!-- Display the movie genre dynamically from the database -->
                        <p>Cast: <?php echo $trend1['movieCast']; ?></p> <!-- Appearance of the actors participating in the film dynamically from the database -->
                        <a href= <?php echo "movies/" . $trend1['movieLink'] . ".php"; ?>><i class="fas fa-ticket-alt"></i> Book Now!</a> <!-- Insert the movie link dynamically from the database -->
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $trend1Cover;?>" class="movie-img"> <!-- Display the title dynamically from the database-->
                    </div>
                </div>
            </div>

            <div class="mySlides">
                <div class="row">
                    <div class="col-md-6 left-box">
                        <h2><?php echo $trend2['movieTitle']; ?></h2>
                        <p><?php echo $trend2['movieDesc']; ?></p>
                        <p>Genre: <?php echo $trend2['movieGenre']; ?></p>
                        <p>Cast: <?php echo $trend2['movieCast']; ?></p>    
                        <a href= <?php echo "movies/" . $trend2['movieLink'] . ".php"; ?>><i class="fas fa-ticket-alt"></i> Book Now!</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $trend2Cover;?>" class="movie-img">
                    </div>
                </div>
            </div>

            <div class="mySlides">
                <div class="row">
                    <div class="col-md-6 left-box">
                        <h2><?php echo $trend3['movieTitle']; ?></h2>
                        <p><?php echo $trend3['movieDesc']; ?></p>
                        <p>Genre: <?php echo $trend3['movieGenre']; ?></p>
                        <p>Cast: <?php echo $trend3['movieCast']; ?></p>    
                        <a href= <?php echo "movies/" . $trend3['movieLink'] . ".php"; ?>><i class="fas fa-ticket-alt"></i> Book Now!</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $trend3Cover;?>" class="movie-img">
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div style="text-align:center" id="gotomovies"> <!-- Div for the slider bullets as well as destination of the "Movies" button of the menu -->
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        </div> <!--  End of the bullet div -->

        <script> //Javascript for the proper functioning of the slider bullets
            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}    
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active";
            }
        </script>
    </div> <!-- End of the slider div -->

    <div class="container movies"> <!-- Div for the movies -->
        <br>
        <h1>Movies &#127916;</h1>
        <div class="row">   <!-- Use bootstrap to create the two columns that contain the movies -->
            <div class="col-md-6">
                <div class="row">
                <?php               
                    if(mysqli_num_rows($movcol1sql) > 0){   //Dynamic visualization of the content of the $movcol1sql variable
                        while($row = mysqli_fetch_array($movcol1sql)){
                            $movcolCover = substr($row['movieCover'],3); //Using the "substr" method as, the movie Cover value in the database starts with ".. /"
                            echo '<div class="col-6"><a href="movies/'. $row['movieLink'].'.php"> <img src="'.$movcolCover.'"> </a></div>';
                        }
                    }                         
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<div class="row">';                
                    if(mysqli_num_rows($movcol2sql) > 0){   //Dynamic visualization of the content of the $movcol2sql variable
                        while($row = mysqli_fetch_array($movcol2sql)){
                            $movcolCover = substr($row['movieCover'],3);
                            echo '<div class="col-6"><a href="movies/'. $row['movieLink'].'.php"> <img src="'.$movcolCover.'"> </a></div>';
                        }
                    }              
                ?>
            </div>
        </div>
    </div>
  
<?php require 'includes/footer.php' ?>  <!-- Call the file necessary to execute the above code, footer.php -->
