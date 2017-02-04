<?php
try{
	$db = new PDO('mysql:host=denis-moureu.fr;dbname=camagru;charset=utf8', 'camagru', 'camagru');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	 echo 'Échec lors de la connexion : ' . $e->getMessage();
}

  $renderDir = './rendu/';


	function checkLogInSignIn($login) {
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

function checkLogIn ($db, $login, $passwd) {
	$cursor = $db->query('SELECT * FROM user');
	while ($data = $cursor->fetch()) {
		if ($data['login'] === $login)
			if ($data['passwd'] !== $passwd)
				return 'Wrong password';
			else
			{
				$_SESSION['logged_id'] = $data['id'];
				return ;
			}
	}
	return 'Invalid login';
	$cursor->closeCursor();
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

?>
