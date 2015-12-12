<?php
	require('connexionBdd.php');
	echo "test0";
	if(isset($_GET['utilisateur'], $_GET['cle']) AND !empty($_GET['utilisateur']) AND !empty($_GET['cle'])){
		$nomUtilisateur = htmlspecialchars(urldecode($_GET['utilisateur']));
		echo "test1";
		$cle = htmlspecialchars($_GET['cle']);
		echo "test2";
		$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND cleActivation = ?");
		$req->execute(array($nomUtilisateur, $cle));
		$utilisateursExist = $req->rowCount();
		echo $utilisateursExist;
		if ($utilisateursExist == 1){
			$utilisateur1 = $req->fetch();
			echo $utilisateur1;
			if($utilisateur1['actif'] == 0) {
				$updateUtilisateur = $bdd->prepare("UPDATE utilisateurs SET actif = 1 WHERE nomUtilisateur = ? AND cleActivation = ?");
				$updateUtilisateur->execute(array($nomUtilisateur, $cle));
				echo $updateUtilisateur;
				echo "Votre compte a bien été confirmé";
			} else {
				echo "Votre compte a déjà été confirmé";
			}
		} else {
			echo "L'utilisateur n'existe pas !";
		}
	}
?>