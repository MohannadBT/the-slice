<?php

session_start();
include 'get_distance.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Search</title>
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

	<section>
		<article>
			<form method="get" action="" class="form">
				<h1>Search</h1><br>
				<label>Name:</label><br>
				<input type="text" name="name" placeholder="Write restaurant name"style="width: 200px"><br><br>
				<label>Address:</label><br>
				<input type="text" name="address" placeholder="Write restaurant address"style="width: 200px"><br><br>
				<label>Min Stars</label><br>
				<input type="number" name="stars" min="1" max="5" placeholder="Write restaurant min stars" style="width: 200px"><br><br><br>
				<input type="submit" name="submit" class="btn" value="Filter">
			</form>
		</article>
		<?php

			if (isset($_GET["submit"])) {
				?>
					<aside>
						<h1>Search result</h1>
						<?php

							$con = new PDO('mysql:host=localhost;dbname=restaurants', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

							$request = $con->query("SELECT * FROM restaurants WHERE name like '%".$_GET['name']."%' and address LIKE '%".$_GET['address']."%' ORDER BY id DESC");
							$request1 = $con->query("SELECT * FROM restaurants WHERE address LIKE '%".$_GET['address']."%' ORDER BY id DESC");


							$datas = array();
							if($_GET["address"] != ""){
							if($info1 = $request1->fetch()){
								$addee = $_GET["address"];
								//$raddee = $info1["address"]; 
								//$distance = getDistance($addee, $raddee, "K");
								
								if(mysqli_num_rows($request1)>0){
									while ($row = mysqli_fetch_assoc($request1)) {
										$a = $row["address"];
										$distance = getDistance($addee, $a, "K");
										$datas[] = $rows;

									}
								}
							}
						    }	

							SORT_ASC($datas);

							while ($info = $request->fetch()) {
								//get averge stars of this restaurant and filter using user input
								$check = $con->query("SELECT AVG(star) as avg FROM reviews WHERE restaurantid = ".$info["id"]);
								if ($check->fetch()["avg"] >= $_GET['stars'] or $_GET['stars'] == '') {
									?>
										<div class="all_rest">
											<div class="rest">
												<img src="<?php echo $info["photo"]; ?>">
												<h2><?php echo $info["name"]; ?></h2>
												<j3><?php echo $info["address"]; ?></j3>
												<a href="restaurant.php?id=<?php echo $info["id"]; ?>" class="btn">More</a>
											</div>
										</div>
									<?php
								}
							}

						?>
						
					</aside>
				<?php
			}

		?>
	</section>
</body>
</html>