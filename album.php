<?php

if ($_GET['action'] == "delete" && $_GET['id'] > 0) {
  $id = intval($_GET['id']);
	$sql = "DELETE FROM `img` WHERE `id` = ".$id." AND `uid` = ".$_SESSION['logged_id'];
	$req = $db->query($sql) or die(mysql_error);

	if ($req->rowCount() == 1)
		unlink($renderDir.'pict-'.$id.'.jpeg');
}

if ($_GET['action'] == "view" && $_GET['id'] > 0) {
  $id = intval($_GET['id']);
  echo   '<img src="./rendu/pict-'.$id.'.jpeg">';
  include "layout/form/com.php";
}

echo '<p>Galery</p>';

$sql = "SELECT * FROM img";
foreach  ($db->query($sql) as $row) {

	echo '<div class="thumb">
          <a href="./index.php?page=gallery&action=view&id='.$row['id'].'">
            <img src="./rendu/pict-'.$row['id'].'.jpeg">';
                    	if ($row['uid'] == $_SESSION['logged_id']) {
                    		echo '<a class="del" href="index.php?page=gallery&action=delete&id='.$row['id'].'">
                    			<img src="./resources/delete.png">
                    		</a>';
                    	}
  echo '   </a>
        </div>';
}
?>
