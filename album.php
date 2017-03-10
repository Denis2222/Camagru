<?php
$max_par_page = 3;

if ($_GET['action'] == "delete" && $_GET['id'] > 0) {
  $id = intval($_GET['id']);
	$sql = "DELETE FROM `img` WHERE `id` = ".$id." AND `uid` = ".$_SESSION['logged_id'];
	$req = $db->query($sql) or die(mysql_error);

	if ($req->rowCount() == 1)
		unlink($renderDir.'pict-'.$id.'.jpeg');
}

if ($_GET['action'] == "view" && $_GET['id'] > 0) {
  $id = intval($_GET['id']);
  echo '<div class="view decobox">
  <div class="imgfull" ">'; //style="background-image:url(\'./rendu/pict-'.$id.'.jpeg\');
  echo   '<img src="./rendu/pict-'.$id.'.jpeg"></div>';
  include "layout/form/com.php";
  echo "</div>";
}

echo '<p>Galery</p>';

$sql = 'SELECT COUNT(*) as nb FROM img';

$req = $db->query($sql);
$data = $req->fetch();
$req->closeCursor();

$nb = $data['nb'];
$nb_page = ceil($nb/$max_par_page);

echo '<div class="gallery decobox">';

$start = intval($_GET['p']);
$sql = "SELECT * FROM img  ORDER BY id DESC LIMIT ".$start.",".$max_par_page;
foreach  ($db->query($sql) as $row) {

	echo '<div class="thumb">
          <div class="pict" style="background-image:url(\'./rendu/pict-'.$row['id'].'.jpeg\');" onclick="document.location=\'./index.php?page=gallery&action=view&id='.$row['id'].'\'">
            ';//<img src="./rendu/pict-'.$row['id'].'.jpeg">
            	if ($row['uid'] == $_SESSION['logged_id']) {
            		echo '<a class="del" href="index.php?page=gallery&action=delete&id='.$row['id'].'">
            			<img src="./resources/delete.png">
            		</a>';
            	}
  echo '   </div>
        </div>';
}

echo '</div><div class="gallery decobox pagination">';
for($x = 0; $x < $nb_page ; $x++)
{
  if (($x*$max_par_page) == $start)
    echo "<a class='selected' href='?p=".($x*$max_par_page)."'>".($x+1)."</a>";
  else {
    echo "<a href='?p=".($x*$max_par_page)."'>".($x+1)."</a>";
  }
}
echo '';


?>

</div>
