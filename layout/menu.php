<p>Menu</p>
<?php
$sql = "SELECT * FROM img ORDER BY id DESC LIMIT 4";
foreach  ($db->query($sql) as $row) {

	echo '<div
class="thumb"
style="background-image:url(\''.$renderDir.'pict-'.$row['id'].'.jpeg\');"
onclick="document.location=\'./index.php?page=gallery&action=view&id='.$row['id'].'\'"></div>';
}
?>
