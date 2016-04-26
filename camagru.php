<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=denis-moureu.fr;dbname=camagru;charset=utf8', 'camagru', 'camagru');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}



echo 'ok';

$reponse = $bdd->query('SELECT * FROM users');

while ($donnees = $reponse->fetch())
{
?>
    <p>
		Login : <?php echo $donnees['login'];?>
   </p>
<?php
}
?>
