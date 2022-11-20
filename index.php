<?php 
require 'database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require 'includes/header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, header.php 

$db = new Db(); //Δημιουργία object της κλάσης Db

$trend1 = $db->get_movie(5); //Αποθήκευση του αποτελέσματος της function get_movie της κλάσης Db στη μεταβλητή $trend1
$trend1Cover = substr($trend1['movieCover'],3); //Χρήση της μεθόδου "substr" καθώς, η τιμή του movieCover στη βάση δεδομένων ξεκινάει με "../"

$trend2 = $db->get_movie(6); //Αποθήκευση του αποτελέσματος της function get_movie της κλάσης Db στη μεταβλητή $trend2
$trend2Cover = substr($trend2['movieCover'],3); 

$trend3 = $db->get_movie(8); //Αποθήκευση του αποτελέσματος της function get_movie της κλάσης Db στη μεταβλητή $trend3
$trend3Cover = substr($trend3['movieCover'],3); 

$movcol1sql = $db->get_home_movies_col1(); //Αποθήκευση του αποτελέσματος της function get_home_movies_col1 της κλάσης Db στη μεταβλητή $movcol1sql
$movcol2sql = $db->get_home_movies_col2(); //Αποθήκευση του αποτελέσματος της function get_home_movies_col2 της κλάσης Db στη μεταβλητή $movcol2sql

?>

    <div class="container trending-movies">  <!-- Div για το trending slider -->
        <h1>Trending Movies&#128293;</h1>
        <br>
        <div class="slideshow-container">
            <div class="mySlides">
                <div class="row">
                    <div class="col-md-6 left-box">
                        <h2><?php echo $trend1['movieTitle']; ?></h2> <!-- Εμφάνιση του τίτλου της ταινίας δυναμικά από τη βάση δεδομένων -->
                        <p><?php echo $trend1['movieDesc']; ?></p> <!-- Εμφάνιση της περιγραφής της ταινίας δυναμικά από τη βάση δεδομένων -->
                        <p>Genre: <?php echo $trend1['movieGenre']; ?></p> <!-- Εμφάνιση του είδους της ταινίας δυναμικά από τη βάση δεδομένων -->
                        <p>Cast: <?php echo $trend1['movieCast']; ?></p> <!-- Εμφάνιση των ηθοποιών που συμμετέχουν στη ταινία δυναμικά από τη βάση δεδομένων -->
                        <a href= <?php echo "movies/" . $trend1['movieLink'] . ".php"; ?>><i class="fas fa-ticket-alt"></i> Book Now!</a> <!-- Εισαγωγή του link της ταινίας δυναμικά από τη βάση δεδομένων -->
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $trend1Cover;?>" class="movie-img"> <!-- Εμφάνιση του τίτλου δυναμικά από τη βάση δεδομένων -->
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

        <div style="text-align:center" id="gotomovies"> <!-- Div για τα bullets του slider καθώς και προορισμός του κουμπιού "Movies" του μενού -->
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        </div> <!--  Κλείνει το div των bullet -->

        <script> //Javascript για τη σωστή λειτουργία των bullets του slider
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
    </div> <!-- Κλείσιμο του slider div -->

    <div class="container movies"> <!-- Div για τις ταινίες -->
        <br>
        <h1>Movies &#127916;</h1>
        <div class="row">   <!-- Χρήση bootstrap για τη δημιουργία των δύο στηλών που περιέχουν τις ταινίες -->
            <div class="col-md-6">
                <div class="row">
                <?php               
                    if(mysqli_num_rows($movcol1sql) > 0){   //Δυναμική απεικόνιση του περιεχομένου της μεταβλητής $movcol1sql
                        while($row = mysqli_fetch_array($movcol1sql)){
                            $movcolCover = substr($row['movieCover'],3); //Χρήση της μεθόδου "substr" καθώς, η τιμή του movieCover στη βάση δεδομένων ξεκινάει με "../"
                            echo '<div class="col-6"><a href="movies/'. $row['movieLink'].'.php"> <img src="'.$movcolCover.'"> </a></div>';
                        }
                    }                         
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<div class="row">';                
                    if(mysqli_num_rows($movcol2sql) > 0){   //Δυναμική απεικόνιση του περιεχομένου της μεταβλητής $movcol2sql
                        while($row = mysqli_fetch_array($movcol2sql)){
                            $movcolCover = substr($row['movieCover'],3);
                            echo '<div class="col-6"><a href="movies/'. $row['movieLink'].'.php"> <img src="'.$movcolCover.'"> </a></div>';
                        }
                    }              
                ?>
            </div>
        </div>
    </div>
  
<?php require 'includes/footer.php' ?>  <!-- Κλήση του απαραίτητου για την εκτέλεση του παραπάνω κώδικα αρχείου, footer.php -->