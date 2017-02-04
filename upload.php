<?php
session_start();
include("config.php");

$data = $_POST['img'];

if($_SESSION['logged_user'])
{
	if ($_SESSION['logged_id'])
	{
		if ($db)
		{
			$sql = "INSERT INTO  `img` (`uid`, `data`, `plus`) VALUES ('".$_SESSION['logged_id']."', '".$_POST['img']."', 'test');";
			$db->query($sql) or die(mysql_error);
			$imagedata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			$id = $db->lastInsertId();
			$toys = json_decode($_POST['toys'], true);
			$dest = imagecreatefromstring($imagedata);
			foreach($toys as $key => $toy) {
				$toys[$key]['gd'] = imagescale(imagecreatefrompng ($toy['src']), $toy['width']);
				imagecopy ($dest, $toys[$key]['gd'], $toy['left'], $toy['top'], 0, 0, imagesx($toys[$key]['gd']), imagesy($toys[$key]['gd']) );
			}
			imagejpeg ( $dest , $renderDir.'pict-'.$id.'.jpeg', 90);
		}
	}
}
header('Location: ./');
exit;
?>
