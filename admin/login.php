<?php
session_start(); //Εκκίνηση του session
require '../database/Db.class.php'; //Κλήση του απαραίτητου για την σύνδεση με τη βάση δεδομένων και την εκτέλεση ερωτημάτων αρχείου κλάσης Db.class.php

$db = new Db(); //Δημιουργία object της κλάσης Db

if (isset($_SESSION['loggedin'])) { //Αν έχει πραγματοποιηθεί σύνδεση χρήστη τότε πραγματοποιείται ανακατεύθυνση στο index.php
	header('Location: index.php');
}

function phpAlert($msg) { //Δημιουργία της μεθόδου phpAlert που εμφανίζει ένα javascript alert που περιέχει ένα μήνυμα
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
	<section class="h-100"> <!--  Section που περιέχει το login form καθώς και το brand image-->
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
	</section>
	<?php
	if(isset($_POST['loginbtn'])) //Έλεγχος αν έχει γίνει υποβολή των στοιχείων στo login form
	{
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$username = $db->escape_string($user); //Αποθήκευση του αποτελέσματος της function escape_string της κλάσης Db στη μεταβλητή $pass
		$password = $db->escape_string($pass);

		
		$row = $db->admin_login($username,$password); //Καταχώρηση του αποτελέσματος στη μεταβλητή $row
		$count = $row['User']; //Καταχώρηση του αριθμού των αποτελεσμάτων του sql query της function admin_login της κλάσης Db στη μεταβλητή $count

		if($count > 0){ //Έλεγχος αν ο αριθμός των εγγραφών είναι μεγαλύτερος του μηδενός
		$_SESSION['loggedin'] = TRUE; //Αν είναι, γίνεται καταχώρηση της τιμής "TRUE" στη μεταβλητή $_SESSION['loggedin']
		$_SESSION['name'] = $_POST['username']; //και του $username στη μεταβλητή $_SESSION['name']
			header('Location: index.php');
		}else{ //Αν ο αριθμός των εγγραφών δεν είναι μεγαλύτερος του μηδενός τότε εμφανίζεται το κατάλληλο μήνυμα
			phpAlert("Invalid username and password");
		}
	}
$db->close(); //Τερματισμός της σύνδεσης με τη βάση	
?>
</body>
</html>