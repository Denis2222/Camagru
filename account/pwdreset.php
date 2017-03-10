<?php

if ($_POST['PWDRESET'] == 'Modifier') {
  $newpwd = trim(htmlspecialchars($_POST['newpasswd']));
  $token = trim(htmlspecialchars($_POST['token']));
  $passwd = hash(whirlpool, $newpwd);
  $req = $db->exec("UPDATE user SET passwdlost = '', passwd = '".$passwd."' WHERE passwdlost = '".$token."' ");
  echo "Changement de mot de passe OK";
} else {

  $token = trim(htmlspecialchars($_GET['token']));

  $sql = 'SELECT COUNT(*) as nb FROM user WHERE passwdlost = "'.$token.'"';

  $req = $db->query($sql);
  $data = $req->fetch();
  $req->closeCursor();

  if ($data['nb'] == 1) {
    ?>
    <div class="view decobox">
      <form method="post" action="">
      	<p>Pour changer votre mot de passe</p>
      	Nouveau mot de passe : <input type="text" name="newpasswd" value="" ><br />
        <input type="hidden" name="token" value="<?php echo $token;?>" ><br />
      	<input type="submit" name="PWDRESET" value="Modifier">
      </form>
    </div>
    <?php
  } else {
    echo 'Token Timeout';
  }
}
?>
