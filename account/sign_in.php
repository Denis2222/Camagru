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
		$_SESSION['logged_user'] = $login;
		while ($data = $cursor->fetch()) {
			if ($data['login'] == $login) {
				mail($email, 'Inscription', "Vous venez de vous inscrire sur ce super site inutile ! Bravo !");
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

<form method="post" action="">
	<?php
		if ($error)
			echo "<p>$error</p>";
	?>
	<p> CREATE ACCOUNT </p>
	Identifiant : <input type="text" name="login" value="<?php echo $_POST['login']; ?>" ><br />
	Email : <input type="text" name="email" value="<?php echo $_POST['email']; ?>"><br />
	Mot de passe : <input type="password" name="passwd" value=""><br />
	Confirmer mot de passe: <input type="password" name="confirm_passwd" value=""/><br />
	<input type="submit" name="submit" value="OK">
</form>
