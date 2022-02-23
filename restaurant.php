<?php

session_start();

error_reporting(0);
//get info

$con = new PDO('mysql:host=localhost;dbname=restaurants', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$request = $con->query("SELECT * FROM restaurants WHERE id = ".$_GET['id']);

$data = $request->fetch();

if (isset($_POST['submit'])) {
	$review = $_POST['review'];
	$star = $_POST['star'];
	if (isset($_SESSION["id"])) {
		$name = $_SESSION['name'];
	}else {
		$name = "Anonymous";
	}

	$request = $con->query("INSERT INTO reviews (username, restaurantid, review, star) VALUES ('".$name."',".$_GET["id"].",'".$review."',".$star.")");

	header("location: restaurant.php?id=".$_GET["id"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $data["name"] ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<a href="index.php">
			<img src="imgs/logo.png" >
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

	<section>
		<article>
			<div>
				<img src="<?php echo $data["photo"] ?>">
			</div>
			<div>
				<h1><?php echo $data["name"]; ?></h1>
				<h3><?php echo $data["address"]; ?></h3>
				<p><?php echo $data["description"]; ?></p>
				<p><?php echo preg_replace("#\n#", "<br>", $data["menu"]); ?></p>
			</div>
		</article>
		<aside>

		<h1>Reviews</h1>

		<?php	
		if ($_SESSION["type"] == "0") {
			?>
			<form method="post" class="review">
				<h2>Add review</h2>
				<textarea placeholder="review" name="review" style="width: 500px; height: 100px;" required></textarea><br>
				<input type="number" name="star" placeholder="Star" style="width: 500px" min="1" max="5" required><br>
				<input type="submit" name="submit" value="Comment" class="btn">
			</form>
			<?php
		}
		?>
			<?php

				$request = $con->query("SELECT * FROM reviews WHERE restaurantid = ".$_GET['id']." ORDER BY id DESC");

				while ($info = $request->fetch()) {
					?>
						<div class="review">
							<h2><?php echo $info["username"]; ?></h2>
							<h3>(<?php echo $info["star"]; ?>) Stars</h3>
							<p><?php echo $info["review"]; ?></p>
						</div>
					<?php
				}

			?>
			
		</aside>
	</section>
</body>
</html>