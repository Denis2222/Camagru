<?php
try{
	$db = new PDO('mysql:host=denis-moureu.fr;dbname=camagru;charset=utf8', 'camagru', 'camagru');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	 echo 'Échec lors de la connexion : ' . $e->getMessage();
}
?>
