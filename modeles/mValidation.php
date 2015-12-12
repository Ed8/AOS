<?php
	require('connexionBdd.php');

	if(isset($_GET['nomUtilisateur'], $_GET['cle']) AND !empty($_GET['nomUtilisateur']) AND !empty($_GET['cle'])){
		$nomUtilisateur = htmlspecialchars(urldecode($_GET['nomUtilisateur']));
		$cle = htmlspecialchars($_GET['cle']);
		
		$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND cleActivation = ?");
		$req->execute(array($nomUtilisateur, $cle));
		$utilisateursExist = $req->rowCount();

		if ($utilisateursExist == 1){
			$utilisateur1 = $utilisateursExist->fetch();
			if($utilisateur1['actif'] == 0) {
				$updateUtilisateur = $bdd->prepare("UPDATE utilisateurs SET actif = 1 WHERE nomUtilisateur = ? AND cleActivation = ?");
				$updateUtilisateur->execute(array($nomUtilisateur, $cle));
				echo "Votre compte a bien été confirmé";
			} else {
				echo "Votre compte a déjà été confirmé";
			}
		} else {
			echo "L'utilisateur n'existe pas !";
		}
	}
?>