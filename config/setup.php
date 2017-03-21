<?php
include("./database.php");

try{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	 echo 'Échec lors de la connexion : ' . $e->getMessage();
}

echo "<a href='?action=generate'>Generate DB</a></br>";
echo "<a href='?action=clean'>Clean all</a></br>";


$CREATESQL = "
USE ".$DB_NAME.";
CREATE TABLE IF NOT EXISTS `com` (
`id` int(11) NOT NULL,
  `iid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `img` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `data` mediumblob NOT NULL,
  `plus` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `like` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `iid` int(11) NOT NULL,
  `note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `passwd` varchar(500) NOT NULL,
  `passwdlost` varchar(100) NOT NULL,
  `confirm` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `com`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `img`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `like`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `com`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `img`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
ALTER TABLE `like`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
";

if ($_GET['action'] == "generate")
{
	$req = $db->query($CREATESQL);

	$req->closeCursor();
}

if ($_GET['action'] == "clean")
{

	foreach($TABLES as $table)
	{
		$req = $db->query("show tables like \"".$table."\";");
		$info = $req->fetch();
		$req->closeCursor();
		if ($info)
		{
			$req = $db->query("DROP TABLE `".$table."`;");
		}
		$req->closeCursor();
	}

	$files = glob('../rendu/*.jpeg'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
	    unlink($file); // delete file
	}
}

	foreach($TABLES as $table)
	{
		$req = $db->query("show tables like \"".$table."\";");
		$info = $req->fetch();
		if ($info)
			echo "".$table." OK ";
		else
			echo "".$table." NOK ";
		echo "</br>";
	}
?>
<a href="../">Accueil</a>
