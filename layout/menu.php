<aside class="aside-2">
<?php
$sql = "SELECT * FROM img";
foreach  ($db->query($sql) as $row) {

	echo '<div class="thumb"><img src="./rendu/pict-'.$row['id'].'.jpeg"></div>';
}
?>
</aside>
