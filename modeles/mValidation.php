<?php
	require('connexionBddTemporaire.php');
	
	if(isset($_GET['utilisateur'], $_GET['cle']) AND !empty($_GET['utilisateur']) AND !empty($_GET['cle'])){
		$nomUtilisateur = htmlspecialchars(urldecode($_GET['utilisateur']));
		$cle = htmlspecialchars($_GET['cle']);

		$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND cleActivation = ?");
		$req->execute(array($nomUtilisateur, $cle));
		$utilisateursExist = $req->rowCount();

		if ($utilisateursExist == 1){
			$utilisateur1 = $req->fetch();
			$mdp = $utilisateur1['mdpUtilisateur']; // Pour le script de création de compte unix 
			$mail = $utilisateur1['email'];
			$mdpCrypt = sha1($utilisateur1['mdpUtilisateur']); // Pour la base de données définitive
			if($utilisateur1['actif'] == 0) {
				require('connexionBdd.php');
				$reqNewBdd = $bdd->prepare("INSERT INTO utilisateurs(nomUtilisateur,mdpUtilisateur,email,cleActivation,actif) VALUES (?,?,?,?,?)");
				$reqNewBdd->execute(array($nomUtilisateur,$mdpCrypt,$mail,$cle,"1"));
				exec('sudo ./script/adduser.sh '.$nomUtilisateur.' '.$mdp);
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