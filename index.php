<?php
session_start();

require_once('config.php');
include 'layout/header.php';
if ($_GET['log_out'] == 'true') {
	$_SESSION['logged_user'] = NULL;
}
if (!$_SESSION['logged_user'] && !$_GET['page'] && $_POST['submit'] !== 'sign_in')
	include 'account/log_in.php';
else if (!$_SESSION['logged_user'] && $_GET['page'] == 'sign_in')
	include 'account/sign_in.php';
else {
	if (!$_GET['page'])
		include 'app/main.php';
	if ($_GET['page'] == 'account')
		include 'account/account.php';
}

include 'layout/footer.php';
?>
