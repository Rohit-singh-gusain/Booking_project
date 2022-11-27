<?php
session_start(); //Start the session
require 'database/Db.class.php'; //Call the necessary class file (Db.class.php) to connect to the database and run queries

$db = new Db(); //Create a Db class object

if(isset($_SESSION['login'])){  //If a user login has occurred then redirect to index.php
	header("Location: index.php");
}

function phpAlert($msg) { //Create the phpAlert method that displays a javascript alert containing a message and then redirects
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'login.php\';</script>';
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>PHPFLIX - Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="shortcut icon" href="/images/a-master-favicon.ico">
</head>

<body class="login-form">
	<section class="h-100"> <!-- Section containing login and registration forms as well as the brand image -->
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper" style="margin-left:auto; margin-right:auto;">
					<div class="brand">
						<img src="images/logo-small.png" alt="logo">
					</div>
					<div class="button-box">
						<div id="swapbtn"></div>
						<button type="button" class="toggle-btn" onclick="login()">Log In</button> <!-- Button which when "pressed" calls the javascript method login() -->
						<button type="button" class="toggle-btn" onclick="register()">Register</button> <!-- Button which when "pressed" calls the javascript method register() -->
					</div>
					<br>	
					<div id="fbody" class="form-box">
						<div class="card fat">
							<div class="card-body" >																
								<form action="" id="login" style="transition: .5s;" method="POST">	<!-- Login Form -->						
									<h4 class="form-title">Login</h4>
									<div class="form-group">
										<label for="username">Username</label>
										<input id="username" type="text" class="form-control" name="username" required autofocus>
									</div>

									<div class="form-group">
										<label for="password">Password</label>
										<input id="password" type="password" class="form-control" name="password" required data-eye>
									</div>
									<div class="form-group m-0">
										<button type="submit" name="loginbtn" value="Login" class="btn btn-primary btn-block">
											Login
										</button>
									</div>
								</form>
							</div>
					
							<div class="card-body" >								
								<form action="" id="register" style="transition: .5s;" method="POST"> <!-- Registration Form -->
									<h4 class="form-title">Register</h4>
									<div class="form-group">
										<label for="name">Name</label>
										<input id="name" type="text" class="form-control" name="name" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" title="Must contain only letters" required autofocus>
									</div>
									<div class="form-group">
										<label for="surname">Surname</label>
										<input id="surname" type="text" class="form-control" name="surname" pattern="[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώ]{2,}" title="Must contain only letters" required>
									</div>
									<div class="form-group">
										<label for="surname">Username</label>
										<input id="username" type="text" class="form-control" name="username" required>
									</div>
									<div class="form-group">
										<label for="phone">Phone Number</label>
										<input id="phone" type="tel" class="form-control" name="phone" pattern="[0-9]{10}" required>
									</div>

									<div class="form-group">
										<label for="email">E-Mail Address</label>
										<input id="email" type="email" class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
									</div>

									<div class="form-group">
										<label for="password">Password</label>
										<input id="password" type="password" class="form-control" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
											   title="Must contain at least one  number, one uppercase, one lowercase letter, and at least 8 characters" required data-eye>
									</div>
									<div class="form-group m-0">
										<button type="submit" name="registerbtn" value="register" class="btn btn-primary btn-block">
											Register
										</button>
									</div>
								</form>
							</div>
						</div>
						
					</div>
					<div id="foo" class="footer">
						Copyright &copy; 2021 &mdash; PHPFLIX 
					</div>
				</div>
			</div>
		</div>
	</section> <!-- End of login & register sections -->
	<?php
	if(isset($_POST['loginbtn'])) //Check if the data have been submitted to the login form
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$username = $db->escape_string($user); //Save the result of function escape_string of the Db class in the $pass variable
		$password = $db->escape_string($pass);

		$userInfo = $db->get_user_info($username);
		if(mysqli_num_rows($userInfo) > 0) //Check if the data stored in the $userInfo variable is more than zero
		{
			while($row=mysqli_fetch_array($userInfo))
			{
				if(password_verify($password, $row['pass']))//Decryption and verification of user code
				{		
					$_SESSION['login'] = $username;  //If correct, the $username is entered in the variable $_SESSION['username']
					if(isset($_SESSION['currenturl'])){ //Check if the variable $_SESSION['currenturl'] (header.php) has been created
						echo "<script type='text/javascript'> document.location = '" . $_SESSION['currenturl'] ."'; </script>";
					}else{
						echo "<script type='text/javascript'> document.location = 'home.php'; </script>";
					}
				}else{ //If the items are incorrect, the appropriate message is displayed
					phpAlert("Invalid username or password");
				}
			}
		}else{ //if the number of records is not greater than zero the appropriate message is displayed
			phpAlert("Invalid username or password");
		}
	}

	

	if(isset($_POST['registerbtn'])) //Check if the data have been submitted to the register form
	{
		$firstname = $_POST['name'];
		$lastname = $_POST['surname'];
		$usrname = $_POST['username'];
		$phonenumber = $_POST['phone'];
		$Email = $_POST['email'];
		$passwrd = $_POST['password'];
		$fname = $db->escape_string($firstname);
		$lname = $db->escape_string($lastname);
		$username = $db->escape_string($usrname);
		$phone = $db->escape_string($phonenumber);
		$email = $db->escape_string($Email);
		$pass = $db->escape_string($passwrd);
		$pass = $db->pass_hush($pass); //Save the result of function pass_hust of the  Db class in the $pass variable
		
		$exists = 0; //Use an auxiliary variable as a flag

		
		$usernameExists = $db->username_exists($username);
		$emailExists = $db->email_exists($email);
		
		
			if (($usernameExists['username'] === $username) || ($emailExists['email'] === $email)){ //if such a record exists, the appropriate message is displayed
			phpAlert("Username or email already exists");
			$exists = 1; //The value of the flag changes
			}
		
		if($exists== 0){ //if the flag value remains the same the user is registered in the database
			$db->register_user("$fname", "$lname", "$username", "$phone", "$email", "$pass");
			phpAlert("User created succesfully!");
			}
	}
	$db->close(); //End the connection to the database
	?>
	<script> //Javascript for the correct operation of the toggle buttons between login and register and change in the style of the form depending on the choice
		var log = document.getElementById("login");
		var reg = document.getElementById("register");
		var btn = document.getElementById("swapbtn");

		function register(){
			log.style.left = "-400px";
			reg.style.left = "0px";
			btn.style.left =  "110px";
			document.getElementById("fbody").style.height = '800px'; 
			document.getElementById("fbody").style.transition = '.5s';
			document.getElementById("fbody").style.borderBottom = '0';
			document.getElementById("foo").style.marginTop = '-140px';
			document.getElementById("foo").style.transition = '.5s';
			
		}
		function login(){
			log.style.left = "0px";
			reg.style.left = "400px";
			btn.style.left =  "0px";
			document.getElementById("fbody").style.height = '285px';
			document.getElementById("fbody").style.transition = '.5s';
			document.getElementById("fbody").style.borderBottom = '1.8px solid #dfdfdf';
			document.getElementById("fbody").style.borderRadius = '0.30rem';
			document.getElementById("foo").style.marginTop = '40px';
			document.getElementById("foo").style.transition = '.5s';
			
		}
	</script>
	
</body>
</html>
