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

    //Function that inserts into the database the details of a new reservation
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

    

     //Function that returns all information related to that id
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
    //Function that returns all records from the table t_movies whose title starts from the content of the variable $movieTitle
    //as the way prices were entered into the booking options.php only the first word of the movie title was assigned to them)
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

    //Function that returns all records from the t_movies table
    function get_all_movies()
    {
        return mysqli_query($this->conn, "SELECT * FROM t_movies");
    }

     //Function that returns the total number of records from the t_movies table
     function get_movies_num()
     {
         $sql = mysqli_query($this->conn, "SELECT * FROM t_movies");

         if (!$sql) 
		{
		    die("Error: Data not found..");
		}

         return mysqli_num_rows($sql);
     }

    //Function that returns the total number of records from the t_booking table
    function get_bookings_num()
    {
        $sql = mysqli_query($this->conn, "SELECT * FROM t_booking");

        if (!$sql) 
		{
		    die("Error: Data not found..");
		}

        return mysqli_num_rows($sql);
    }

    //Function that returns the number of bookings and the maximum number of seats for the movie with the specified id
    function get_max_booking_seats($movieID)
    {
        return mysqli_query($this->conn, "SELECT COUNT(t_booking.bookingID) AS bookings, t_movies.movieSeats FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID WHERE t_booking.movieID = '$movieID'");
    }

    //Function that returns all information related to the specific username
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
    //Function that returns information about movieCover and movieLink related to the ids of movies which are odd numbers
    function get_home_movies_col1()
    {
        return mysqli_query($this->conn, "SELECT movieCover, movieLink FROM t_movies WHERE movieID %2 != 0");       
    }

    //Function that returns information about the movieCover and movieLink associated with the ids of movies which are even numbers
    function get_home_movies_col2()
    {
        return mysqli_query($this->conn, "SELECT movieCover, movieLink FROM t_movies WHERE movieID %2 = 0");      
    }

    //Function that returns all the information from the table t_booking and the movieTitle from the table t_movies corresponding to the username of the user logged in to the site
    function get_user_bookings($username)
    {
        $result = mysqli_query($this->conn, "SELECT t_booking.* , t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID WHERE username =  '$username'");

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

        return $result;
    }

    //Function to use mysqli_real_escape_string to securely enter data into the database
    function escape_string($string)
    {
        return mysqli_real_escape_string($this->conn, $string);
    }

    //Function to encrypt the password set by the user
    function pass_hush($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    //Function that returns the database records for that username
    function get_user_info($username)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM t_users WHERE username='$username'");

        if (!$result) 
		{
		    die("Error: Data not found..");
		}

        return $result;
    }   

    //Function that returns a single record containing that username
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

    //Function that returns a single record containing that email
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

    //Function that registers the user in the database
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

    //Function for adding a movie to the database
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

    //Function for movie editing
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

    //Function that deletes from the t_booking table the item with an id equal to the variable $id
    function delete_booking($id)
	{
		mysqli_query($this->conn, "DELETE FROM t_booking WHERE bookingID = '$id'")
		             or die(mysql_error());  	

		return TRUE;
	}

    //Function that deletes from the t_movies table the item with an id equal to the variable $id
    function delete_movie($id)
    {
        mysqli_query($this->conn, "DELETE FROM t_movies WHERE movieID = '$id'")
                        or die(mysql_error());  	

        return TRUE;
    }

    //Function that returns all records from table t_booking and movieTitle from table t_movies in descending order relative to the bookTimestamp field
    function get_all_bookings_and_title()
    {
        return mysqli_query($this->conn, "SELECT t_booking.*, t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID ORDER BY bookTimestamp DESC");
    }

    //Function that returns three records from the t_booking table and the movieTitle from the t_movies table in descending order relative to the bookTimestamp field
    function get_three_bookings_and_title()
    {
        return mysqli_query($this->conn, "SELECT t_booking.*, t_movies.movieTitle FROM t_booking JOIN t_movies ON t_booking.movieID = t_movies.movieID ORDER BY bookTimestamp DESC LIMIT 3");
    }

    //Function that returns the number of records in the database with the specified username and password(encrypted)
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
    
    //Function to terminate the connection to the database	
    function close()
	{
		mysqli_close($this->conn);
	}
}
?>
