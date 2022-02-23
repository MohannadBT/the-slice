<?php

session_start();
 

$e = false;

if (isset($_POST["submit"])) {
	$email = $_POST["email"];
	$password = md5($_POST["password"]);

	$con = new PDO('mysql:host=localhost;dbname=restaurants', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	$request = $con->query("SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."'");

	if ($request->rowCount() == 1) {
		$info = $request->fetch();

		$_SESSION["id"] = $info["id"];
		$_SESSION["name"] = $info["name"];
		$_SESSION["email"] = $info["email"];
		$_SESSION["type"] = $info["type"];

		header("location: index.php");
	}else {
		$e = true;
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style_log_reg.css">

	<title>Login</title>
	</head>
<body style="background-image: url(bg.jpg);">
	<p style="padding-right: 120px; margin-left: -220px;"><img src="imgs/logo.png" width="950" height="950" alt="logo"></p>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group"> 
				<input type="email" placeholder="Email" name="email" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text" style="padding-top: 5px;">Don't have an account? <a href="register.php">Register Here</a>, or go <a href="index.php">Home</a>.</p>
			<p class="login-text" style="padding-top: 20px;"> Or Login with social media</p>
        	<div class="login-social">
            	<a href="#" class="facebook"><i class="fa fa-facebook"></i> Facebook</a>
            	<a href="#" class="twitter"><i class="fa fa-twitter"></i> Twitter</a>
            	<a href="#" class="google-plus"><i class="fa fa-google-plus"></i> Google Plus</a>
				<a href="#" class="linkedin"><i class="fa fa-linkedin"></i> Linkedin</a>
        	</div>
		</form>
	</div>
</body>
</html>