<?php
$login = trim(htmlspecialchars($_POST['login']));
$email = trim(htmlspecialchars($_POST['email']));
$passwd = htmlspecialchars($_POST['passwd']);
$confirm = htmlspecialchars($_POST['confirm_passwd']);

if ($_POST['submit'] == 'OK') {
	if (!$error = checkLogInSignIn($login))
		if (!$error = checkEmail($email))
			if(!$error = checkPasswd($passwd, $confirm))
				$error = checkAlreadyUsed($db, $login, $email);
	if (!$error) {
		$passwd = hash(whirlpool, $passwd);
		$req = $db->prepare('INSERT INTO user(login, email, passwd) VALUES(:login, :email, :passwd)');
		$req->execute(array(
			'login' => $login,
			'email' => $email,
			'passwd' => $passwd,
			));
		$cursor = $db->query('SELECT * FROM user WHERE login = "' . $login . '"');

		while ($data = $cursor->fetch()) {
			if ($data['login'] == $login) {

				$token = bin2hex(random_bytes(30));
		    	$req = $db->exec("UPDATE user SET confirm = '".$token."' WHERE login = '".$login."' ");
		    	mail($email, 'Confirmation de votre inscription sur camagru', "Valider ce lien afin 'activer votre compte http://localhost:8080/Camagru/index.php?page=signconfirm&token=".$token);
		    	mess('Email de confirmation envoye');

				//mail($email, 'Inscription', "Vous venez de vous inscrire sur ce super site inutile ! Bravo !");
			}
		}
		$cursor->closeCursor();
	}
}

if ($_SESSION["logged_user"])
{
	?>
		<SCRIPT LANGUAGE="JavaScript">
			document.location.href="./"
		</SCRIPT>
	<?php
}
?>
<div class="view decobox">
<form method="post" action="">
	<?php
		if ($error)
			mess($error);
	?>
	<p> CREATE ACCOUNT </p>
	Identifiant : <input type="text" name="login" value="<?php echo $_POST['login']; ?>" ><br />
	Email : <input type="text" name="email" value="<?php echo $_POST['email']; ?>"><br />
	Mot de passe : <input type="password" name="passwd" value=""><br />
	Confirmer mot de passe: <input type="password" name="confirm_passwd" value=""/><br />
	<input type="submit" name="submit" value="OK">
</form>
</div>
