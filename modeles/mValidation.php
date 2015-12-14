<?php
	require('connexionBddTemporaire.php');
	
	if(isset($_GET['utilisateur'], $_GET['cle']) AND !empty($_GET['utilisateur']) AND !empty($_GET['cle'])){
		$nomUtilisateur = htmlspecialchars(urldecode($_GET['utilisateur']));
		$cle = htmlspecialchars($_GET['cle']);

		$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ?");
		$req->execute(array($nomUtilisateur));
		$utilisateursExist = $req->rowCount();

		if ($utilisateursExist == 1){
			$utilisateur1 = $req->fetch();
			// Pour le script de création de compte unix 
			$mdp = $utilisateur1['mdpUtilisateur']; 
			$mail = $utilisateur1['email'];
			// Pour la base de données définitive
			$mdpCrypt = sha1($utilisateur1['mdpUtilisateur']); 
			$actif = $utilisateur1['actif'];
			// Connexion à la base de donnée définitive
			require('connexionBdd.php');
			// Insert des informations dans la nouvelle base avec le mot de passe crypter
			$reqNewBdd = $bdd->prepare("INSERT INTO utilisateurs(nomUtilisateur,mdpUtilisateur,email,cleActivation,actif) VALUES (?,?,?,?,?)");
			$reqNewBdd->execute(array($nomUtilisateur,$mdpCrypt,$mail,$cle,$actif));
			// Récupération des informations dans la nouvelle base
			$reqNewBddActif = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND cleActivation");
			$reqNewBddActif->execute(array($nomUtilisateur, $cle));
			$actifVerification = $reqNewBddActif->fetch();
			// Vérification si le compte à été activer dans la nouvelle base 
			if($actifVerification['actif'] == 0) {	
				$updateUtilisateur = $bdd->prepare("UPDATE utilisateurs SET actif = 1 WHERE nomUtilisateur = ? AND cleActivation = ?");
				$updateUtilisateur->execute(array($nomUtilisateur, $cle));
				$output = shell_exec('/var/www/aos/script/addUser.sh '.$nomUtilisateur.' '.$mdp);
				$erreur = "Votre compte a bien été confirmé";
				$header="MIME-Version: 1.0\r\n";
				$header.='From:"aos.itinet.fr"<support@aos.itinet.fr>'."\n";
				$header.='Content-Type:text/html; charset="utf-8"'."\n";
				$header.='Content-Transfert-Encoding: 8bit';

				$message='
				<html>
					<body>
						<div align="center">
							<p>Vous trouverez ci-joint vos informations utiles à votre connexion :<p>
							<p>Votre nom d\'utilisateur : '.$nomUtilisateur.' .<p>
							<p>Votre mot de passe : '.$mdp.' .<p>
						</div>
					</body>
				</html>
				';
				mail($mail, "Compte autorisé", $message, $header);
				//header ("Refresh: 5;URL=index.php?p=index");
			} else {
				$erreur = "Votre compte a déjà été confirmé";
			}
		} else {
			$erreur = "L'utilisateur n'existe pas !";
		}
	}
?>