<?php
session_start();
ob_start();
if ($_GET['log_out'] == 'true') {
	$_SESSION['logged_user'] = NULL;
	header('Location: index.php');
}

require_once('config.php');
include 'layout/header.php';
include 'layout/body.php';
include 'layout/menu.php';
include 'layout/footer.php';
ob_end_flush();
?>
