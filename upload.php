<?php
session_start();
include("config.php");
print_r($_SESSION);
print_r($_POST);

$data = $_POST['img'];

if($_SESSION['logged_user'])
{
	if ($_SESSION['logged_id'])
	{
		if ($db)
		{
			$sql = "INSERT INTO  `img` (`uid`, `data`, `plus`) VALUES ('".$_SESSION['logged_id']."', '".$_POST['img']."', 'test');";
			echo $sql;
			$db->query($sql) or die(mysql_error);
		}
	}


/*
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
file_put_contents('./img/image.png', $data);
*/
}
?>
