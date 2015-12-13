<?php
	require('connexionBdd.php');

	if(isset($_GET['utilisateur'], $_GET['cle']) AND !empty($_GET['utilisateur']) AND !empty($_GET['cle'])){
		$nomUtilisateur = htmlspecialchars(urldecode($_GET['utilisateur']));
		$cle = htmlspecialchars($_GET['cle']);

		$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND cleActivation = ?");
		$req->execute(array($nomUtilisateur, $cle));
		$utilisateursExist = $req->rowCount();
		
		if ($utilisateursExist == 1){
			$utilisateur1 = $req->fetch();
			if($utilisateur1['actif'] == 0) {
				$updateUtilisateur = $bdd->prepare("UPDATE utilisateurs SET actif = 1 WHERE nomUtilisateur = ? AND cleActivation = ?");
				$updateUtilisateur->execute(array($nomUtilisateur, $cle));
				$erreur= "Votre compte a bien été confirmé";
				header ("Refresh: 5;URL=index.php?p=index");
			} else {
				$erreur = "Votre compte a déjà été confirmé";
			}
		} else {
			$erreur = "L'utilisateur n'existe pas !";
		}
	}
?>