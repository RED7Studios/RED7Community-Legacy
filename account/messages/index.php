<?php
/*
  File Name: index.php
  Original Location: /account/messages/index.php
  Description: The main messages file.
  Author: Mitchell (Creaous)
  Copyright (C) RED7 STUDIOS 2021
*/

include_once $_SERVER["DOCUMENT_ROOT"]. "/assets/common.php";

if ($maintenanceMode == "on") {
	header("location: /maintenance.php");
}

// Initialize the session
if(!isset($_SESSION)){
	session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: ../../login.php");
	exit;
}
?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Account Settings</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

		<link rel="stylesheet" href="<?php echo $STORAGE_URL; ?>/assets/css/style.css">

		<link rel="stylesheet" href="<?php echo $STORAGE_URL; ?>/assets/css/sidebar.css">

		<script src="<?php echo $STORAGE_URL; ?>/assets/js/fontawesome.js"></script>
	</head>

	<body>
		<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/account/navbar.php" ?>
		<div class="page-content-wrapper">
				<?php
				if (isset($your_isBanned))
				{
					if ($your_isBanned == 1)
					{
						echo "<script type='text/javascript'>location.href = '/errors/banned.php';</script>";
					}
				}
				
				if (isset($maintenanceMode))
				{
					if ($maintenanceMode == "on")
					{
						echo "<script type='text/javascript'>location.href = '/errors/maintenance.php';</script>";
					}
				}
				?>
				<main class="col-lg-10">
					<h2><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Messages</h2>

					<p>This feature is not finished yet.</p>
				</main>
			</div>
		</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>