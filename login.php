<?php
session_start(); //Εκκίνηση του session
require 'database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php
$db = new Db(); 
function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα και στη συνέχεια ανακατευθύνει
	echo '<script type="text/javascript">alert("' . $msg . '");window.location = \'login.php\';</script>';
}

if(isset($_SESSION['login'])){
	header("Location: index.php");
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
	<section class="h-100"> <!-- Section που περιέχει τα login και registration forms καθώς και το brand image -->
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper" style="margin-left:auto; margin-right:auto;">
					<div class="brand">
						<img src="images/logo-small.png" alt="logo">
					</div>
					<div class="button-box">
						<div id="swapbtn"></div>
						<button type="button" class="toggle-btn" onclick="login()">Log In</button> <!-- Κουμπί το οποίο κατά το "πάτημα" του καλεί τη javascript μέθοδο login() -->
						<button type="button" class="toggle-btn" onclick="register()">Register</button> <!-- Κουμπί το οποίο κατά το "πάτημα" του καλεί τη javascript μέθοδο register() -->
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
	</section> <!-- Τέλος login & register section -->
	<?php
	if(isset($_POST['loginbtn'])) //Έλεγχος αν έχει γίνει υποβολή των στοιχείων στo login form
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$username = $db->escape_string($user); //Αποθήκευση του αποτελέσματος της function escape_string της κλάσης Db στη μεταβλητή $pass
		$password = $db->escape_string($pass);

		$userInfo = $db->get_user_info($username);
		if(mysqli_num_rows($userInfo) > 0) //Έλεγχος αν τα δεδομένα που είναι αποθηκευμένα στη μεταβλητή $userInfo είναι περισσότερα του μηδενός
		{
			while($row=mysqli_fetch_array($userInfo))
			{
				if(password_verify($password, $row['pass']))//Αποκρυπτογράφηση και επαλήθευση του κωδικού χρήστη
				{		
					$_SESSION['login'] = $username;  //Αν είναι, γίνεται καταχώρηση του $username στη μεταβλητή $_SESSION['username']
					if(isset($_SESSION['currenturl'])){ //Έλεγχος αν έχει δημιουργηθεί η μεταβλητή $_SESSION['currenturl'] (header.php)
						echo "<script type='text/javascript'> document.location = '" . $_SESSION['currenturl'] ."'; </script>";
					}else{
						echo "<script type='text/javascript'> document.location = 'home.php'; </script>";
					}
				}else{ //Αν τα στοιχεία είναι λανθασμένα εμφανίζεται το κατάλληλο μήνυμα
					phpAlert("Invalid username or password");
				}
			}
		}else{ //Αν ο αριθμός των εγγραφών δεν είναι μεγαλύτερος του μηδενός τότε εμφανίζεται το κατάλληλο μήνυμα
			phpAlert("Invalid username or password");
		}
	}

	

	if(isset($_POST['registerbtn'])) //Έλεγχος αν έχει γίνει υποβολή των στοιχείων στo register form
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
		$pass = $db->pass_hush($pass); //Αποθήκευση του αποτελέσματος της function pass_hust της κλάσης Db στη μεταβλητή $pass
		
		$exists = 0; //Χρήση βοηθητικής μεταβλητής ως flag

		
		$usernameExists = $db->username_exists($username);
		$emailExists = $db->email_exists($email);
		
		
			if (($usernameExists['username'] === $username) || ($emailExists['email'] === $email)){ //Αν υπάρχει τέτοια εγγραφή εμφανίζεται το κατάλληλο μήνυμα
			phpAlert("Username or email already exists");
			$exists = 1; //Αλλάζει η τιμή του flag
			}
		
		if($exists== 0){ //Αν η τιμή του flag παραμένει ίδια, πραγματοποιείται εγγραφή του χρήστη στη βάση
			$db->register_user("$fname", "$lname", "$username", "$phone", "$email", "$pass");
			phpAlert("User created succesfully!");
			}
	}
	$db->close(); //Τερματισμός της σύνδεσης με τη βάση δεδομένων
	?>
	<script> //Javascript για τη σωστή λειτουργία των κουμπιών εναλλαγής μεταξύ login και register και αλλαγή στο style της φόρμας ανάλογα με την επιλογή
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