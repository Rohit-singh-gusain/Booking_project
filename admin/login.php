<?php
session_start(); //Start the session
require '../database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries

$db = new Db(); //Create a Db class object

if (isset($_SESSION['loggedin'])) { //If a user login has occurred then redirect to index.php
	header('Location: index.php');
}

function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
	echo '<script type="text/javascript">alert("' . $msg . '");</script>';
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>PHPFLIX - Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/admin-login.css">
	<link rel="shortcut icon" href="../images/a-master-favicon.ico">
	
</head>

<body class="login-form">
	<section class="h-100"> <!--  Section containing login and registration forms as well as the brand image-->
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper" style="margin-left:auto; margin-right:auto;">
					<div class="brand">
						<img src="../images/logo-small.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form action="" method="POST"> <!-- Login Form -->	
								<div class="form-group">
									<label for="email">Username</label>
									<input id="username" type="text" name="username" class="form-control" name="username"required autofocus>
								</div>
								<div class="form-group">
									<label for="password">Password
									</label>
									<input id="password" type="password" name="password" class="form-control" name="password" required data-eye>
								</div>
								<div class="form-group m-0">
									<button type="submit" name="loginbtn" value="Login" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2021 &mdash; PHPFLIX 
					</div>
				</div>
			</div>
		</div>
	</section>  <!-- End of login section -->
	<?php
	if(isset($_POST['loginbtn'])) //Check if the data have been submitted to the login form
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$username = $db->escape_string($user); //Save the result of function escape_string of the Db class in the $pass variable
		$password = $db->escape_string($pass);

		
		$row = $db->admin_login($username,$password); //Assign the result in the variable $row
		$count = $row['User']; //Store the number of sql query results of function admin_login of the DB class in the $count variable

		if($count > 0){ //Check if the number of records is greater than zero
		$_SESSION['loggedin'] = TRUE; //If it is, the value "TRUE" is assigned in the variable $_SESSION['loggedin']
		$_SESSION['name'] = $_POST['username']; //and the $username in the variable $_SESSION['name']
			header('Location: index.php');
		}else{ //if the number of records is not greater than zero the appropriate message is displayed
			phpAlert("Invalid username and password");
		}
	}
$db->close(); //End the connection to the database	
?>
</body>
</html>
