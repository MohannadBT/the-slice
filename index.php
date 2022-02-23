<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="style.css">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css%22%3E">

    <link rel="stylesheet" type="text/css" href="styleFooter.css">

	<title>The Slice</title>
</head>
<body>
	<header>
		<a href="index.php">
			<img src="imgs/logo.png">
		</a>
	</header>
	<nav style="box-shadow: 0 5px 5px  #d9ba2a;">
		<?php
			if (isset($_SESSION['id'])) {
				if ($_SESSION["type"] == "1") {
					?>
						<a href="panel.php">My Restaurant</a>
					<?php
				}
				?>
					<a href="logout.php">Logout</a>
				<?php
			}else {
				?>
					<a href="login.php">Login</a>
					<a href="register.php">Register</a>
				<?php
			}
		?>
		<a href="filter.php">Search</a>
	</nav>

	<section id="A">
		<article style="border-radius: 15px;">
			<div>
				<img style="border-radius: 15px;" src="imgs/food.jpeg">
			</div>
			<div>
				<h1>Find the best restaurants here</h1>
				<p>You can easly find any restaurant, and filter the result as you like, by keyword, place, ratings stars...etc</p>
				<a href="filter.php" class="btn">Search</a>
			</div>
		</article>

		<aside id="B">
			<h1 style="background-color: #30475E; border-radius: 15px;">The latest restaurants</h1>
			<div class="all_rest">
			<?php

				$con = new PDO('mysql:host=localhost;dbname=restaurants', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

				$request = $con->query("SELECT * FROM restaurants ORDER BY id DESC");

				while ($info = $request->fetch()) {
					?>
						<div class="rest" style="border-radius: 15px;">
							<img style="border-radius: 15px;" src="<?php echo $info["photo"]; ?>">
							<h2><?php echo $info["name"]; ?></h2>
							<a href="restaurant.php?id=<?php echo $info["id"]; ?>" class="btn">More</a>
						</div>
					<?php
				}

			?>
			</div>
			
		</aside>
	</section>

	<footer class="footer">
       <div class="container">
           <div class="row">
               <div class="footer-col">
                   <h4>company</h4>
                   <ul>
                   <li><a href="#A">about us</a></li>
                    <li><a href="#B">our services</a></li>
                    <li><a href="#">privacy policy</a></li>
                   </ul>
               </div>
               <div class="footer-col">
                   <h4>get help</h4>
                   <ul>
                       <li><a href="#">FAQ</a></li>
                       <li><a href="#">shipping</a></li>
                       <li><a href="#">returns</a></li>
                       <li><a href="#">order status</a></li>
                       <li><a href="#">payment options</a></li>
                   </ul>
               </div>
               <div class="footer-col">
               <h4>Suggestion</h4>
                       <ul style="padding:0">
                            <li><a href="mailto:mhalaa184@gmail.com">Send to the developer to make our website better</a></li>
                    </ul>
               </div>
               <!-- <div class="footer-col">
                   <h4>follow us</h4>
                   <div class="social-links">
                       <a href="https://www.facebook.com/%22%3E" ><i class="fab fa-facebook-f"></i></a>
                       <a href="https://www.twitter.com/%22%3E" ><i class="fab fa-twitter"></i></a>
                       <a href="https://www.instagram.com/%22%3E"><i class="fab fa-instagram"></i></a>
                       <a href="https://www.linkedin.com/%22%3E"><i class="fab fa-linkedin-in"></i></a>
                   </div> -->
               </div>
           </div>
       </div>
  </footer>
</body>
</html>