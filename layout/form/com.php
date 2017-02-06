<?php
if ($_POST['submitcom']) {
  echo $_POST['message'];
}


$sql = "SELECT * FROM com WHERE iid = ".$id."";
$cursor = $db->query($sql);
while ($data = $cursor->fetch()) {

}
 ?>

<form method="post" action="">
	<input type="text" name="message" placeholder="Commentez la photo de ">
	<input type="submit" name="submitcom" value="OK">
</form>
