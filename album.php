<?php
session_start();
include("config.php");

if ($_SESSION['logged_id'])
{
	if ($db)
	{
		$sql = "SELECT * FROM img WHERE uid = '".$_SESSION['logged_id']."'";
		foreach  ($db->query($sql) as $row) {
			echo '<img src="'.$row['data'].'">';
			//print_r($row);
		}
	}
}
?>
