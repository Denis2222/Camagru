<?php
try{
	$db = new PDO('mysql:host=denis-moureu.fr;dbname=camagru;charset=utf8', 'camagru', 'camagru');
}
catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
}
?>
