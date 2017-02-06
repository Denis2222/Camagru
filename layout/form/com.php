<div class="com-container">

<?php
if ($_POST['submitcom']) {
  $sql = "INSERT INTO `com` (`id`, `iid`, `uid`, `message`) VALUES (NULL, :iid, :uid, :message);";

  $req = $db->prepare($sql);

  $req->execute(array(
    'iid' => $id,
    'uid' => $_SESSION['logged_id'],
    'message' => htmlentities($_POST['message'])));
}

$sql = "SELECT * FROM com INNER JOIN user ON user.id = com.uid WHERE iid = ".$id."";
$cursor = $db->query($sql);
while ($data = $cursor->fetch()) {
  echo "<div>".$data['login'].":".$data['message']."</div>";
}
 ?>

<form method="post" action="">
	<input type="text" name="message" placeholder="Commentez la photo de ">
	<input type="submit" name="submitcom" value="OK">
</form>
</div>
