<?php

if ($_POST['PWDLOST'] == 'Envoyer') {
  $email = trim(htmlspecialchars($_POST['email']));
  $req = $db->query('SELECT COUNT(*) as nb FROM user WHERE email = "'.$email.'"');
  $data = $req->fetch();
  $req->closeCursor();

  if ($data['nb'] == 1) {
    $token = bin2hex(random_bytes(30));
    $req = $db->exec("UPDATE user SET passwdlost = '".$token."' WHERE email = '".$email."' ");
    mail($email, 'Mot de passe oublie ?', "Pour entrer un nouveau mot de passe rendez vous a cette adresse http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=pwdreset&token=".$token);
    mess("Email envoyé verifiez vos spam si pas recu dans les 5s");
  } else {
    mess("Cet email n'est pas enregistre");
  }
} else {
    ?>
    <div class="view decobox">
      <form method="post" action="">
      	<p>M'envoyer un lien par email pour modifier le mot de passe de mon compte ! </p>
      	Email : <input type="text" name="email" value="" ><br />
      	<input type="submit" name="PWDLOST" value="Envoyer">
      </form>
    </div>
    <?php
}
?>
