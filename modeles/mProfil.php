<?php
	session_start();
    if(!isset($_SESSION['idUtilisateur'])){
        header('Location: index.php');
    }
	//Vérification si le formulaire été posté
	if(isset($_POST['confMotdePasseForm'])){
		if(!empty($_POST['ancienMotDePasse']) AND !empty($_POST['nouveauMotDePasse']) AND !empty($_POST['confMotDePasse'])) {
			//Récupération des variables
			$ancienMotDePasse = sha1($_POST['ancienMotDePasse']);
			$nouveauMotDePasse = sha1($_POST['nouveauMotDePasse']);
			$confMotDePasse = sha1($_POST['confMotDePasse']);
			$motDePasseUnix = htmlspecialchars($_POST['nouveauMotDePasse']);
			
			require('connexionBdd.php');
			//Vérification dans la bdd que le mot de passe correspond
			$reqVerifMotDePasse = $bdd->prepare("SELECT * FROM utilisateurs WHERE idUtilisateur = ?");
			$reqVerifMotDePasse->execute(array($_SESSION['idUtilisateur']));
			$resultat = $reqVerifMotDePasse->fetch();
			
			if($ancienMotDePasse == $resultat['mdpUtilisateur']){
				//Vérification dans le form que les deux mot de passe correspondent
				if($nouveauMotDePasse == $confMotDePasse){
					//Update du mot de passe dans la bdd
					$updateMotDePasse = $bdd->prepare("UPDATE utilisateurs SET mdpUtilisateur = '$nouveauMotDePasse' WHERE idUtilisateur = ? ");
					$updateMotDePasse->execute(array($_SESSION['idUtilisateur']));
					$output = shell_exec('/var/www/aos/script/changePassword.sh '.$_SESSION['nomUtilisateur'].' '.$motDePasseUnix);
					$messConfProfil = "Votre mot de passe à bien été modifié !";
				} else {
					$messErreurProfil = "Votre mot de passe et la confirmation ne corespondent pas !";
				}
			} else {
				$messErreurProfil = "Votre ancien mot de passe ne correspond pas !";
			}
		} else {
			$messErreurProfil = "Tous les champs ne sont pas remplis !";
		}
	} 
?>