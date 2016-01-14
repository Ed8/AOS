<?php
/* connection a la base de données */
try{
  	$bdd = new PDO('mysql:host=localhost;dbname=aosTemporaire', 'root', 'sshi94');
	$bdd->exec("SET CHARACTER SET utf8");
}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}
?>