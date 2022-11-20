<?php 

class Db
{
    protected $conn;

    function __construct()
    {
        require 'config.php';

        $this->new_conn($config);
    }


    function new_conn($config)
    {
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $db = $config['db'];

        $this->conn = mysqli_connect($host, $username, $password, $db);

        if(!$this->conn)
        {
            die('Could not connect: ' . mysqli_error());
        }
        else 
        {
            return $this->conn;
        }
    }

    //Function που εισάγει στη βάση τα στοιχεία μιας νέας κράτησης
    function create_booking($movieID, $firstName, $lastName, $email, $phoneNumber, $bookDate, $bookTime, $rowLetter, $colNumber, $username)
    {
        mysqli_query($this->conn, "INSERT INTO 
                                    `t_booking`(  movieID,
                                                    firstName,
                                                    lastName,
                                                    email,
                                                    phoneNumber,
                                                    bookDate,
                                                    bookTime,
                                                    rowLetter,
                                                    colNumber,
                                                    username)
                                    VALUES (        '$movieID',
                                                    '$firstName',
                                                    '$lastName',
                                                    '$email',
                                                    '$phoneNumber',
                                                    '$bookDate',
                                                    '$bookTime',
                                                    '$rowLetter',
                                                    '$colNumber',
                                                    '$username')");
    }

    

     //Function που επιστρέφει όλες τις πληροφορίες που σχετίζονται με το συγκεκριμένο id
    function get_movie($movieID)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_movies WHERE movieID  = '$movieID'");
		$row    = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }
    //Function που επιστρέφει όλες τις εγγραφές από τον πίνακα t_movies των οποίων ο τίτλος ξεκινάει από το περιεχόμενο της μεταβλητής $movieTitle
    //καθώς με τον τρόπο που εισήχθησαν οι τιμές στα options του booking.php αντιστοιχήθηκε σε αυτά μόνο η πρώτη λέξη του τίτλου των ταινιών)
    function get_movie_byTitle($movieTitle)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_movies WHERE movieTitle LIKE '$movieTitle%'");
        $row    = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }  

    //Function που επιστρέφει όλες τις εγγραφές από τον πίνακα t_movies
    function get_all_movies()
    {
        return mysqli_query($this->conn, "SELECT * FROM t_movies");
    }

     //Function που επιστρέφει όλες τις εγγραφές από τον πίνακα t_booking
     function get_movies_num()
     {
         $sql = mysqli_query($this->conn, "SELECT * FROM t_movies");

         if (!$sql) 
		{
		    die("Error: Data not found..");
		}

         return mysqli_num_rows($sql);
     }

    //Function που επιστρέφει όλες τις εγγραφές από τον πίνακα t_booking
    function get_bookings_num()
    {
        $sql = mysqli_query($this->conn, "SELECT * FROM t_booking");

        if (!$sql) 
		{
		    die("Error: Data not found..");
		}

        return mysqli_num_rows($sql);
    }

    //Function που επιστρέφει τον αριθμό των κρατήσεων και το μέγιστο αριθμό θέσεων για τη ταινία με το συγκεκριμένο id 
    function get_max_booking_seats($movieID)
    {
        return mysqli_query($this->conn, "SELECT COUNT(t_booking.bookingID) AS bookings, t_movies.movieSeats FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID WHERE t_booking.movieID = '$movieID'");
    }

    //Function που επιστρέφει όλες τις πληροφορίες που σχετίζονται με το συγκεκριμένο username 
    function get_username($username)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }
    //Function που επιστρέφει πληροφορίες για το movieCover και το movieLink που σχετίζονται τα id των ταινιών τα οποία είναι μονοί αριθμοί
    function get_home_movies_col1()
    {
        return mysqli_query($this->conn, "SELECT movieCover, movieLink FROM t_movies WHERE movieID %2 != 0");       
    }

    //Function που επιστρέφει πληροφορίες για το movieCover και το movieLink που σχετίζονται τα id των ταινιών τα οποία είναι ζυγοί αριθμοί
    function get_home_movies_col2()
    {
        return mysqli_query($this->conn, "SELECT movieCover, movieLink FROM t_movies WHERE movieID %2 = 0");      
    }

    //Function που επιστρέφει όλες τις πληροφορίες απο το πίνακα t_booking και το movieTitle από τον πίνακα t_movies που αντιστοιχούν στο username του χρήστη που είναι συνδεμένος στο site
    function get_user_bookings($username)
    {
        $result = mysqli_query($this->conn, "SELECT t_booking.* , t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID WHERE username =  '$username'");

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

        return $result;
    }

    //Function για τη χρήση mysqli_real_escape_string για ασφαλή εισαγωγή δεδομένων στη βάση
    function escape_string($string)
    {
        return mysqli_real_escape_string($this->conn, $string);
    }

    //Function για τη κρυπτογράφηση του κωδικού που θέτει ο χρήστης
    function pass_hush($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    //Function που επιστρέφει τις εγγραφές της βάσης για το συγκεκριμένο username
    function get_user_info($username)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_users WHERE username='$username'");

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

        return $result;
    }   

    //Function που επιστρέφει μία και μόνο εγγραφή η οποία περιέχει το συγκεκριμένο username
    function username_exists($username)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_users WHERE username='$username' LIMIT 1");
        $row = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }

    //Function που επιστρέφει μία και μόνο εγγραφή η οποία περιέχει το συγκεκριμένο email
    function email_exists($email)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_users WHERE username='$email' LIMIT 1");
        $row = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }

    //Function που πραγματοποιεί εγγραφή του χρήστη στη βάση
    function register_user($fname, $lname, $username, $phone, $email, $pass)
    {
        mysqli_query($this->conn, "INSERT INTO 
                                    `t_users` (  	firstName,
                                                    lastName,
                                                    username,
                                                    phoneNumber,
                                                    email,
                                                    pass)
                                    VALUES (        '$fname',
                                                    '$lname',
                                                    '$username',
                                                    '$phone',
                                                    '$email',
                                                    '$pass')");
    }

    //Function για προσθήκη ταινίας στη βάση δεδομένων
    function add_movie($movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration, $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink)
    {
        mysqli_query($this->conn, "INSERT INTO 
                                    t_movies   (  movieCover,
                                                movieLogo,
                                                movieTitle,
                                                movieGenre,
                                                movieDuration,
                                                movieRelDate,
                                                movieDesc,
                                                movieCast,
                                                movieTrailer,
                                                movieSeats,
                                                movieLink)
                                    VALUES (      '$movieCover',
                                                '$movieLogo',
                                                '$movieTitle',
                                                '$movieGenre',
                                                '$movieDuration',
                                                '$movieRelDate',
                                                '$movieDesc',
                                                '$movieCast',
                                                '$movieTrailer',
                                                '$movieSeats',
                                                '$moviepath')");
    }

    //Function για επεξεργασία ταινίας
    function update_movie($movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration, $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink, $movieID)
    {
        mysqli_query($this->conn, "UPDATE `t_movies` SET  movieCover = '$movieCover',
                                                        movieLogo = '$movieLogo',
                                                        movieTitle = '$movieTitle',
                                                        movieGenre = '$movieGenre',
                                                        movieDuration = '$movieDuration',
                                                        movieRelDate = '$movieRelDate',
                                                        movieDesc = '$movieDesc',
                                                        movieCast = '$movieCast',
                                                        movieTrailer = '$movieTrailer',
                                                        movieSeats = '$movieSeats',
                                                        movieLink = '$movieLink'
                                          WHERE         movieID = '$movieID'")
                                          or die(mysql_error()); 

                                          return TRUE;
    }

    //Function που διαγράφει από τον επιλεγμένο πίνακα το στοιχείο με id ίσο με τη μεταβλητή $id
    function delete_booking($id)
	{
		mysqli_query($this->conn, "DELETE FROM t_booking WHERE bookingID = '$id'")
		             or die(mysql_error());  	

		return TRUE;
	}

    //Function που διαγράφει από τον επιλεγμένο πίνακα το στοιχείο με id ίσο με τη μεταβλητή $id
    function delete_movie($id)
    {
        mysqli_query($this->conn, "DELETE FROM t_movies WHERE movieID = '$id'")
                        or die(mysql_error());  	

        return TRUE;
    }

    //Function που επιστρέφει όλες τις εγγραφές από τον πίνακα t_booking και το movieTitle από τον πίνακα t_movies σε φθίνουσα σειρά ως προς το πεδίο bookTimestamp
    function get_all_bookings_and_title()
    {
        return mysqli_query($this->conn, "SELECT t_booking.*, t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID ORDER BY bookTimestamp DESC");
    }

    //Function που επιστρέφει τρεις εγγραφές από τον πίνακα t_booking και το movieTitle από τον πίνακα t_movies σε φθίνουσα σειρά ως προς το πεδίο bookTimestamp
    function get_three_bookings_and_title()
    {
        return mysqli_query($this->conn, "SELECT t_booking.*, t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID ORDER BY bookTimestamp DESC LIMIT 3");
    }

    //Function που επιστρέφει τον αριθμό των εγγραφών στη βάση με τα συγκεκριμένα username και password(κρυπτογραφημένο)
    function admin_login($username, $password)
    {
        $result = mysqli_query($this->conn, "SELECT count(*) AS User FROM t_admins WHERE adminUsername='$username' and adminPassword='".md5($password)."'");
        $row = mysqli_fetch_array($result);

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

		return $row;
    }

    function close()
	{
		mysqli_close($this->conn);
	}
}
?>