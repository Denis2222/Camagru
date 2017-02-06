<div class="com-container">
<?php

$sql = "SELECT COUNT(*) as nb FROM `like` WHERE iid = ".$id." AND uid = ".$_SESSION['logged_id'];
$cursor = $db->query($sql);
$datalikeuser = $cursor->fetch();



if ($_POST['submitcom']) {
  $sql = "INSERT INTO `com` (`id`, `iid`, `uid`, `message`) VALUES (NULL, :iid, :uid, :message);";
  $req = $db->prepare($sql);
  $req->execute(array(
    'iid' => $id,
    'uid' => $_SESSION['logged_id'],
    'message' => htmlentities($_POST['message'])));
}

if ($_POST['submitlike'] && $datalikeuser['nb'] == 0) {
  $sql = "INSERT INTO `like` (`id`, `uid`, `iid`, `note`) VALUES (NULL, :uid, :iid, '1');";
  $req = $db->prepare($sql);
  $req->execute(array(
    'iid' => $id,
    'uid' => $_SESSION['logged_id']));
}

$sql = "SELECT COUNT(*) as nb FROM `like` WHERE iid = ".$id." AND uid = ".$_SESSION['logged_id'];
$cursor = $db->query($sql);
$datalike = $cursor->fetch();


echo '<div class="decobox">';
echo "LIKE: ".$datalike['nb'];


if ($datalikeuser['nb'] == 1)
{

} else {
  ?>
  <form method="post" action="">
    <input type="submit" name="submitlike" value="LIKE">
  </form>
  <?php
}
echo '</div>';
echo '</div>';
echo '<div class="com-container">';

$sql = "SELECT * FROM com INNER JOIN user ON user.id = com.uid WHERE iid = ".$id."";
$cursor = $db->query($sql);
while ($data = $cursor->fetch()) {
  echo "<div class='com'>
          <div class='login'>".$data['login'].":</div>
          <div class='text'>".$data['message']."</div>
        </div>";
}
 ?>
</div>
<div class="com-container">
<form method="post" action="">
	<textarea name="message" placeholder="Commentez la photo de "></textarea>
	<input type="submit" name="submitcom" value="OK">
</form>
</div>
