<?php
$login = trim(htmlspecialchars($_POST['login']));
$passwd = hash(whirlpool, htmlspecialchars($_POST['passwd']));

//$var = "denis";

//$sql = "SELECT * FROM user WHERE login = '".$var."'";
//echo $sql;
//	$cursor = $db->query($sql);

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

if ($_POST['submit'] == 'OK')
	if ($db)
		$error = checkLogIn($db, $login, $passwd);
	if (!$error)
	{
		$_SESSION['logged_user'] = $login;
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
			echo "<p>$error</p>";
	?>
	<p>LOG IN </p>
	Identifiant : <input type="text" name="login" value="" ><br />
	Mot de passe : <input type="password" name="passwd" value=""><br />
	<input type="submit" name="submit" value="OK">
</form>
<p>Password lost? <a href="?page=pwdlost">Reset Password<a><p>


<p>Don't have an account? <a href="?page=sign_in">Sign In<a><p>
