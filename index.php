<?php
session_start();
ob_start();
if ($_GET['log_out'] == 'true') {
	$_SESSION['logged_user'] = NULL;
	header('Location: index.php');
}

require_once('config.php');
include 'layout/header.php';

if (!$_SESSION['logged_user'] && !$_GET['page'] && $_POST['submit'] !== 'sign_in')
	include 'account/log_in.php';
else if (!$_SESSION['logged_user'] && $_GET['page'] == 'sign_in')
	include 'account/sign_in.php';
else if (!$_SESSION['logged_user'] && $_GET['page'] == 'pwdlost')
	include 'account/pwdlost.php';
else if (!$_SESSION['logged_user'] && $_GET['page'] == 'pwdreset')
	include 'account/pwdreset.php';
else {
	if (!$_GET['page'])
		include 'app/main.php';
	if ($_GET['page'] == 'account')
		include 'account/account.php';
}

include 'layout/footer.php';
ob_end_flush();
?>
