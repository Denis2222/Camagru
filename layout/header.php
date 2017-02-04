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
