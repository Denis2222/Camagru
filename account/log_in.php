<?php
$login = trim(htmlspecialchars($_POST['username']));
$passwd = hash(whirlpool, htmlspecialchars($_POST['pwd']));

if ($_POST['submit'] == 'LOGIN')
{
	if ($db)
		$error = checkLogIn($db, $login, $passwd);
	if (!$error)
	{
		$cursor = $db->query('SELECT * FROM user WHERE login = "'.$login.'"');
		$data = $cursor->fetch();

		if ($data['confirm'] != "")
		{
			mess("Confirmez votre email");
		} else {
			$_SESSION['logged_user'] = $login;
			$_SESSION['logged_id'] = $data['id'];
		}
	}
}

if ($_SESSION["logged_user"])
{
	header('Location: ./');
	exit;
}

?>

<form method="post" action="">
	<?php
		if ($error)
			mess($error);
	?>
	<input type="text" name="username" placeholder="login" >
	<input type="password" name="pwd" placeholder="passe">
	<input type="submit" name="submit" value="LOGIN">
</form>

<a href="?page=pwdlost">Reset Password</a>
<a href="?page=sign_in">Sign In</a>
