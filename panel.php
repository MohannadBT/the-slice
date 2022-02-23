<?php

session_start();

$con = new PDO('mysql:host=localhost;dbname=restaurants', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//get saved information about the restaurant if exist

$request = $con->query("SELECT * FROM restaurants WHERE userid = ". $_SESSION["id"]);

if ($request->rowCount() == 1) {
	$info = $request->fetch();

	$old_name = $info["name"];
	$old_address = $info["address"];
	$old_description = $info["description"];
	$old_menu = $info["menu"];
	$old_id = $info["id"];
}else {
	$old_name = '';
	$old_address = '';
	$old_description = '';
	$old_menu = '';
	$old_id = '';
}

if (isset($_POST["clear"])) {
	$request = $con->query('DELETE FROM restaurants WHERE userid = '.$_SESSION["id"]);
    header("location: panel.php");
    exit();
}

if (isset($_POST["submit"])) {

	$name = $_POST["name"];
	$address = $_POST["address"];
	$description = $_POST["description"];
	$menu = $_POST["menu"];
	$photo = "imgs/restaurants_photos/" . $_FILES['photo']["name"];

	//save uploaded photo
	move_uploaded_file($_FILES['photo']["tmp_name"], $photo);


	//check if update or insert
	if ($old_id == '') {
		$request = $con->query('INSERT INTO restaurants (userid, name, address, description, menu, photo) VALUES ('.$_SESSION["id"].',"'.$name.'","'.$address.'","'.$description.'","'.$menu.'","'.$photo.'")');
	}else {
		$request = $con->query('UPDATE restaurants SET name = "'.$name.'", address = "'.$address.'", description = "'.$description.'", menu = "'.$menu.'", photo = "'.$photo.'" WHERE userid = '.$_SESSION["id"]);
	}
	

	header("location: panel.php"); //refresh the page
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit restaurant informations</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<a href="index.php">
			<img src="imgs/logo.png">
		</a>
	</header>
	<nav style="box-shadow: 0 5px 5px  #d9ba2a;">
		<a href="panel.php">My Restaurant</a>
		<a href="logout.php">Logout</a>
		<a href="filter.php">Search</a>
	</nav>

	<section>
		<article>
			<form method="post" action="" class="form" enctype="multipart/form-data">
				<br>
				<label>Name:</label><br>
				<input type="text" name="name" placeholder="Write restaurant name" required value="<?php echo $old_name; ?>"><br><br>
				<label>Address:</label><br>
				<input type="text" name="address" placeholder="Write restaurant address" required value="<?php echo $old_address; ?>"><br><br>
				<label>Description:</label><br>
				<textarea name="description" placeholder="Write restaurant description" required style="height: 100px; width: 300px;"><?php echo $old_description; ?></textarea><br><br>
				<label>Menu:</label><br>
				<textarea name="menu" placeholder="Write restaurant menu" required style="height: 100px; width: 300px;"><?php echo $old_menu; ?></textarea><br><br>
				<label>Photo:</label><br>
				<input type="file" name="photo" required><br><br>

				<input type="submit" name="submit" class="btn" value="Save">

				<?php
				if ($old_id != '') {
					?>

					<button style="border: none; background: none;">
						<a href="restaurant.php?id=<?php echo $old_id; ?>" class="btn">View</a>
					</button>

					<!-- <input type="submit" name="clear" class="btn" value="Delete"> -->
					<?php
				}
				?>

			</form>
			<form method="post" action="" class="form" enctype="multipart/form-data">
			<?php
				if ($old_id != '') {
					?>
					<input type="submit" name="clear" class="btn" value="Delete">
					<?php
				}
				?>
			</form>
		</article>
	</section>
</body>
</html>