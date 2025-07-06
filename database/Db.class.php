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
        $this->conn = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['db']
        );

        if ($this->conn->connect_error) {
            error_log("Database connection failed: " . $this->conn->connect_error);
            throw new Exception("Database connection failed");
        }
        
        // Set charset to utf8mb4 for full Unicode support
        $this->conn->set_charset("utf8mb4");
        
        return $this->conn;
    }

    // Helper method for prepared statements
    private function execute_prepared($sql, $params, $types = "")
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }

        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat("s", count($params)); // default to string type
            }
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Booking functions
    function create_booking($movieID, $firstName, $lastName, $email, $phoneNumber, $bookDate, $bookTime, $rowLetter, $colNumber, $username)
    {
        $sql = "INSERT INTO `t_booking` (movieID, firstName, lastName, email, phoneNumber, bookDate, bookTime, rowLetter, colNumber, username) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $this->execute_prepared($sql, [
            $movieID, $firstName, $lastName, $email, $phoneNumber, 
            $bookDate, $bookTime, $rowLetter, $colNumber, $username
        ]);
    }

    // Movie functions
    function get_movie($movieID)
    {
        $sql = "SELECT * FROM t_movies WHERE movieID = ?";
        $result = $this->execute_prepared($sql, [$movieID]);
        return $result ? $result->fetch_assoc() : false;
    }

    function get_movie_byTitle($movieTitle)
    {
        $sql = "SELECT * FROM t_movies WHERE movieTitle LIKE CONCAT(?, '%')";
        $result = $this->execute_prepared($sql, [$movieTitle]);
        return $result ? $result->fetch_assoc() : false;
    }

    function get_all_movies()
    {
        $result = $this->conn->query("SELECT * FROM t_movies");
        if (!$result) {
            error_log("Query failed: " . $this->conn->error);
            return false;
        }
        return $result;
    }

    function add_movie($movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration, $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink)
    {
        $sql = "INSERT INTO t_movies (movieCover, movieLogo, movieTitle, movieGenre, movieDuration, 
                movieRelDate, movieDesc, movieCast, movieTrailer, movieSeats, movieLink) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $this->execute_prepared($sql, [
            $movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration,
            $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink
        ]);
    }

    function update_movie($movieID, $movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration, 
                         $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink)
    {
        $sql = "UPDATE t_movies SET 
                movieCover = ?, movieLogo = ?, movieTitle = ?, movieGenre = ?, 
                movieDuration = ?, movieRelDate = ?, movieDesc = ?, movieCast = ?, 
                movieTrailer = ?, movieSeats = ?, movieLink = ? 
                WHERE movieID = ?";
        
        return $this->execute_prepared($sql, [
            $movieCover, $movieLogo, $movieTitle, $movieGenre, $movieDuration,
            $movieRelDate, $movieDesc, $movieCast, $movieTrailer, $movieSeats, $movieLink, $movieID
        ]);
    }

    function delete_movie($id)
    {
        $sql = "DELETE FROM t_movies WHERE movieID = ?";
        return $this->execute_prepared($sql, [$id]);
    }

    // User functions
    function register_user($fname, $lname, $username, $phone, $email, $pass)
    {
        $sql = "INSERT INTO t_users (firstName, lastName, username, phoneNumber, email, pass) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        return $this->execute_prepared($sql, [
            $fname, $lname, $username, $phone, $email, $pass
        ]);
    }

    function get_user_info($username)
    {
        $sql = "SELECT * FROM t_users WHERE username = ?";
        $result = $this->execute_prepared($sql, [$username]);
        return $result ?: false;
    }

    function username_exists($username)
    {
        $sql = "SELECT * FROM t_users WHERE username = ? LIMIT 1";
        $result = $this->execute_prepared($sql, [$username]);
        return $result ? $result->fetch_assoc() : false;
    }

    function email_exists($email)
    {
        $sql = "SELECT * FROM t_users WHERE email = ? LIMIT 1";
        $result = $this->execute_prepared($sql, [$email]);
        return $result ? $result->fetch_assoc() : false;
    }

    // Booking functions
    function delete_booking($id)
    {
        $sql = "DELETE FROM t_booking WHERE bookingID = ?";
        return $this->execute_prepared($sql, [$id]);
    }

    function get_user_bookings($username)
    {
        $sql = "SELECT t_booking.*, t_movies.movieTitle 
                FROM t_booking 
                JOIN t_movies ON t_booking.movieID = t_movies.movieID 
                WHERE username = ?";
        
        $result = $this->execute_prepared($sql, [$username]);
        return $result ?: false;
    }

    function get_all_bookings_and_title()
    {
        $sql = "SELECT t_booking.*, t_movies.movieTitle 
                FROM t_booking 
                JOIN t_movies ON t_booking.movieID = t_movies.movieID 
                ORDER BY bookTimestamp DESC";
        
        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("Query failed: " . $this->conn->error);
            return false;
        }
        return $result;
    }

    function get_three_bookings_and_title()
    {
        $sql = "SELECT t_booking.*, t_movies.movieTitle 
                FROM t_booking 
                JOIN t_movies ON t_booking.movieID = t_movies.movieID 
                ORDER BY bookTimestamp DESC 
                LIMIT 3";
        
        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("Query failed: " . $this->conn->error);
            return false;
        }
        return $result;
    }

    // Admin functions
    function admin_login($username, $password)
    {
        $hashedPassword = md5($password);
        $sql = "SELECT count(*) AS User FROM t_admins WHERE adminUsername = ? AND adminPassword = ?";
        $result = $this->execute_prepared($sql, [$username, $hashedPassword]);
        return $result ? $result->fetch_assoc() : false;
    }

    // Utility functions
    function escape_string($string)
    {
        return $this->conn->real_escape_string($string);
    }

    function pass_hash($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    function pass_verify($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

    function close()
    {
        $this->conn->close();
    }

    function __destruct()
    {
        $this->close();
    }
}
?>