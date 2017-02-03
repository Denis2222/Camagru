<?php
$login = trim(htmlspecialchars($_POST['login']));
$email = trim(htmlspecialchars($_POST['email']));
$passwd = htmlspecialchars($_POST['passwd']);
$confirm = htmlspecialchars($_POST['confirm_passwd']);

function checkLogin($login) {
	$login_ws = str_replace (' ', '', $login);
	if (!$login_ws) {
		$_POST['login'] = NULL;
		return 'You must enter a login';
	}
	if (strlen($login_ws) < 3 || strlen($login) > 20) {
		$_POST['login'] = NULL;
		return 'Login minimum size is 3 and maximum size is 20';
	}
}

function checkEmail($email) {
	if (!preg_match("/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/", $email)) {
		$_POST['email'] = NULL;
		return 'Invalid email';
	}
}

function checkPasswd($passwd, $confirm) {
	if (!preg_match("/[A-Z]/", $passwd) || !preg_match("/[0-9]/", $passwd) || strlen(str_replace (' ', '', $passwd)) < 6)
		return 'Password must be minimum 6 characters and must contain atleast one capital lettre (A-Z) and one number (0-9)';
	if ($password !== $confimr)
		return 'Password and Confirm password are different';
}

function checkAlreadyUsed ($db, $login, $email) {
	$cursor = $db->query('SELECT * FROM user');
	while ($data = $cursor->fetch()) {
		if ($data['login'] === $login)
			return 'This login is already used';
		if ($data['email'] === $email)
			return 'This email is already used';
	}
	$cursor->closeCursor();
}

if ($_POST['submit'] == 'OK') {
	if (!$error = checkLogin($login))
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
		$cursor = $db->query('SELECT * FROM user');
		$_SESSION['logged_user'] = $login;
		/*while ($data = $cursor->fetch()) {
			echo $data['login'] . '<br />';
			echo $data['email'] . '<br />';
			echo $data['passwd'] . '<br /><br />';
		}
		$cursor->closeCursor();*/
	}
}

if ($_SESSION["logged_user"])
	header('Location: index.php');
include 'layout/header.php';
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
