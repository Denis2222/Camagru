<html>
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="./resources/style.css">
	<!--<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/navbar_top.css">
	<link rel="stylesheet" type="text/css" href="../css/sign_in.css">-->
	<script src="./resources/webcam.js" async></script>
</head>
<body oncontextmenu="return false;">
	<div class="wrapper">
	<header>
		<div class="logo" onclick="document.location.href='./'"></div>
		<?php
		if ($_SESSION['logged_user']) {
			echo 'Bonjour '.$_SESSION['logged_user'];

			echo '<a href="index.php?page=gallery">Gallery</a>';

			echo '<a href="index.php?page=photo">Photo</a>';

			echo '<a href="index.php?log_out=true">Log out</a>';
		} else {
			include 'account/log_in.php';
		}
		?>
	</header>
