<?php
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
require '../includes/movie-header.php'; //Κλήση του απαραίτητου για την εκτέλεση του παρακάτω κώδικα αρχείου, movie-header.php 

$db = new Db(); //Δημιουργία object της κλάσης Db

$row = $db->get_movie(9); //Αποθήκευση του αποτελέσματος της function get_movie της κλάσης Db στη μεταβλητή $row

function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα και στη συνέχεια ανακατευθύνει
echo '<script type="text/javascript">alert("' . $msg . '");window.location = "' . $_SESSION['currenturl'] .'";</script>';
}
?>

<div class="container"> <!-- Div για το περιεχόμενο της σελίδας -->
  <div class="content-container"> <!-- Container div για τις πληροφορίες της ταινίας -->
    <?php echo '<div class="movie-page-content text-left" style="background: linear-gradient(to bottom, rgba(0,0,0,0), #151515), url('.$row['movieCover'].') no-repeat center center fixed; background-size: cover;">'; 
        echo '<img class="movie-logo" src="'.$row['movieLogo'].'" style="margin-top:260px;">'; ?>
        <p class="movie-desc" style="margin-top:20px;"><?php echo $row['movieDesc'];?></p>            
        <br><br>
        <p class="movie-desc">Genre: <?php echo $row['movieGenre'];?>  </p>
        <br><br>
        <p class="movie-desc">Cast: <?php echo $row['movieCast'];?>   </p> 
        <br><br>  
        <p class="movie-desc">Duration: <?php echo $row['movieDuration'];?> &nbsp;&nbsp; Release Date: <?php echo $row['movieRelDate'];?> </p>  
               </div>
  </div> <!-- Κλείσιμο του container div-->
    <br>
    <div class="trailer-container"> <!-- Div για το trailer της ταινίας -->
        <?php echo $row['movieTrailer'];?>
    </div> <!-- Κλείσιμο trailer div -->

  <?php 
    $id = $row['movieID'];    
    $bookingQuery = $db->get_max_booking_seats($id); //Αποθήκευση του αποτελέσματος της function get_max_booking_seats της κλάσης Db στη μεταβλητή $bookingQuery
    $maxsnum = "";
    $bkngnum = "";
    while($sts = mysqli_fetch_array($bookingQuery)) {
      $maxsnum = $sts['movieSeats'];
      $bkngnum = $sts['bookings'];
    }
    $seats = $maxsnum - $bkngnum; //Υπολογισμός διαθέσιμων θέσεων
  ?>

  <div class="form-container"> <!-- Container div της φόρμας κρατήσεων -->
    <div class="container-form">
      <form action="" method="POST">  <!-- Δημιουργία της φόρμας -->
        <h2>Book your ticket for <?php echo $row['movieTitle'];?>!</h2>
        <?php 
        if($seats != 0) { //Έλεγχος αν οι διαθέσιμες θέσεις δεν είναι 0, αν είναι, τότε δεν εμφανίζεται το περιεχόμενο της φόρμας
          if(!isset($_SESSION['login'])){ //Έλεγχος αν δεν υπάρχει συνδεμένος χρήστης, αν υπάρχει, εμφανίζονται συγκεκριμένα πεδία
            echo '<div class="form-field">';
            echo '<p>Name</p>';
            echo '<input type="text" name="fname" placeholder="Your Name" title="Must contain only letters" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Surname</p>';
            echo '<input type="text" name="lname" placeholder="Your Surname" title="Must contain only letters" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Email</p>';
            echo '<input type="email" name="email" placeholder="Your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>';
            echo '</div>';
            echo '<div class="form-field">';
            echo '<p>Phone Number&nbsp;&nbsp;</p>';
            echo '<input type="phone" name="phone" pattern="[0-9]{10}" placeholder="Your phone number" required>';
            echo '</div>';
          } 
          echo '<div class="form-field">';
          echo '<p>Date</p>';
          echo '<select name="date" required>';
          echo '<option value="" disabled selected>Date</option>';
          echo '<option value="Monday 1 June">Monday 1 June</option>';
          echo '<option value="Tuesday 2 June">Tuesday 2 June</option>';
          echo '<option value="Wednesday 3 June">Wednesday 3 June</option>';
          echo '<option value="Thursday 4 June">Thursday 4 June</option>';
          echo '<option value="Friday 5 June">Friday 5 June</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Time</p>';
          echo '<select name="hour" required>';
          echo '<option value="" disabled selected>Time</option>';
          echo '<option value="15:00">15:00</option>';
          echo '<option value="18:00">18:00</option>';
          echo '<option value="21:00">21:00</option>';
          echo '<option value="23:00">23:00</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Row</p>';
          echo '<select name="row" required>';
          echo '<option value="" disabled selected>Row</option>';
          echo '<option value="Row A">A</option>';
          echo '<option value="Row B">B</option>';
          echo '<option value="Row C">C</option>';
          echo '<option value="Row D">D</option>';
          echo '<option value="Row E">E</option>';
          echo '<option value="Row F">F</option>';
          echo '<option value="Row G">G</option>';
          echo '<option value="Row H">H</option>';
          echo '</select>';
          echo '</div>';
          echo '<div class="form-field">';
          echo '<p>Column</p>';
          echo '<select name="colNumber" required>';
          echo '<option value="" disabled selected>Column</option>';
          echo '<option value="Number 1">1</option>';
          echo '<option value="Number 2">2</option>';
          echo '<option value="Number 3">3</option>';
          echo '<option value="Number 4">4</option>';
          echo '<option value="Number 5">5</option>';
          echo '<option value="Number 6">6</option>';
          echo '<option value="Number 7">7</option>';
          echo '<option value="Number 8">8</option>';
          echo '<option value="Number 9">9</option>';
          echo '<option value="Number 10">10</option>';
          echo '</select>';
          echo '</div>';
          echo '<button type="submit" name="submit" value="submit" class="btn">Submit</button>';
        }
        ?>     
        <p id="seats"></p>      
      </form> <!-- Κλείσιμο του div της φόρμας -->
            <script> //Javascript κώδικας που εμφανίζει ένα κείμενο και τη τιμή της μεταβλητής $seats στο <p> tag με id="seats"         
              document.getElementById("seats").innerHTML = "<?php echo "Available seats: " . $seats?>";
            </script>
    </div>   
    <div class="container-time"><img src="../images/cinema-seats.png" style="width: 90%; height:750px;"></div> <!-- Div που περιέχει την εικόνα με τις θέσεις του κινηματογράφου -->
  </div>    

  <?php 
  if(isset($_SESSION['login'])){ //Έλεγχος αν υπάρχει συνδεμένος χρήστης
   
    $username = $_SESSION['login']; //Αποθήκευση του username του συνδεμένου χρήστη στη μεταβλητή $username
    $row2 = $db->get_username($username); //Αποθήκευση του αποτελέσματος του function get_username της κλάσης Db στη μεταβλητή $row2

    $fname = $row2['firstName'];  //Αποθήκευση πληροφοριών απο τη βάση στις αντίστοιχες μεταβλητές
    $lname = $row2['lastName'];
    $email = $row2['email'];
    $phone = $row2['phoneNumber'];
  } else {                      //Αν δεν υπάρχει συνδεμένος χρήστης τότε στις μεταβλητές αποθηκεύονται τα περιεχόμενα των πεδίων της φόρμας κρατήσεων
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
  }
  $movieTitle = $row['movieTitle'];
  $movieID = $row['movieID'];
  $date = $_POST["date"];
  $hour = $_POST["hour"];
  $row = $_POST["row"];
  $col = $_POST["colNumber"];
 

  if(isset($_POST['submit']))  //Έλεγχος αν έχει "πατηθεί" από τον χρήστη το κουμπί submit και εκτέλεση της function create_booking της κλάσης Db στη βάση δεδομένων
  {
    $db->create_booking("$movieID", "$fname", "$lname", "$email", "$phone", "$date", "$hour", "$row", "$col", "$username");
    phpAlert("Your booking for the movie " . $movieTitle . " was successful!"); //Μήνυμα επιτυχούς εισαγωγής                    
  }
echo '</div>'; //Κλείσιμο του div για το περιεχόμενο της σελίδας
require '../includes/movie-footer.php'; //Κλήση του απαραίτητου για την εκτέλεση του παραπάνω κώδικα αρχείου, movie-footer.php 
?>