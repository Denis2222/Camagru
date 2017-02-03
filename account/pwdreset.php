<?php

if ($_POST['submit'] == 'OK') {
  $newpwd = trim(htmlspecialchars($_POST['newpasswd']));
  $token = trim(htmlspecialchars($_POST['token']));
  $passwd = hash(whirlpool, $newpwd);
  $req = $db->exec("UPDATE user SET passwdlost = '', passwd = '".$passwd."' WHERE passwdlost = '".$token."' ");
  echo "Changement de mot de passe OK";

  echo '<a href="./">Retour accueil</a>';
}

$token = trim(htmlspecialchars($_GET['token']));

$sql = 'SELECT COUNT(*) as nb FROM user WHERE passwdlost = "'.$token.'"';
echo $sql;
  $req = $db->query($sql);
  $data = $req->fetch();
  $req->closeCursor();

  if ($data['nb'] == 1) {
    ?>
    <form method="post" action="">
    	<p>Pour changer votre mot de passe</p>
    	Nouveau mot de passe : <input type="text" name="newpasswd" value="" ><br />
      <input type="hidden" name="token" value="<?php echo $token;?>" ><br />
    	<input type="submit" name="submit" value="OK">
    </form>

    <?php


  } else {
    echo 'OUT';
  }

?>
