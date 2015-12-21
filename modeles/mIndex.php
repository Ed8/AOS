<?php
//Connexion modal

require('connexionBdd.php');

if(isset($_POST['confConnexion'])){
	$nomUtilisateur = htmlspecialchars($_POST['nomUtilisateur']);
	$motDePasse = sha1($_POST['motDePasse']);
	
	if(!empty($nomUtilisateur) AND !empty($motDePasse)){
		$reqUtilisateur = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND mdpUtilisateur = ?");
		$reqUtilisateur->execute(array($nomUtilisateur, $motDePasse));
		$utilisateurExist = $reqUtilisateur->rowCount();
		
		if($utilisateurExist == 1){
			$utilisateurInfo = $reqUtilisateur->fetch();
			if($utilisateurInfo['actif'] == 1){
			session_start();
			$_SESSION['idUtilisateur'] = $utilisateurInfo['idUtilisateur'];
			$_SESSION['nomUtilisateur'] = $utilisateurInfo['nomUtilisateur'];
			header("Location:index.php?p=indexMembre");
			} else {
				$messErreurConnexion = "Veuillez confirmez votre compte !";
			}	
		} else {
			$messErreurConnexion = "Mauvais nom d'utilisateur ou mot de passe !";
		}
	} else {
		$messErreurConnexion = "Tous les champs doivent être complétés !";
	}
}
?>


<?php
//Inscription modal

if(isset($_POST['confInscription'])){
	$nomUtilisateur=htmlspecialchars($_POST['nomUtilisateur']);
	$adresseMail=htmlspecialchars($_POST['mail']);
	$confMail=htmlspecialchars($_POST['confMail']);
	$motDePasse=$_POST['motDePasse'];
	$confMotDePasse=$_POST['confMotDePasse'];
	
	if(!empty($_POST['nomUtilisateur']) AND !empty($_POST['mail']) and !empty($_POST['confMail']) AND !empty($_POST['motDePasse']) AND !empty($_POST['confMotDePasse'])){
		$nomUtilisateurLength = strlen($nomUtilisateur);
		if($nomUtilisateurLength <= 20){
			if($adresseMail == $confMail){
					if($motDePasse == $confMotDePasse){
						$longueurCle = 9;
						$cle = "";
						for($i=1; $i<$longueurCle; $i++){
							$cle .= mt_rand(0,9);
						}
						$activation = "0";
						require('connexionBddTemporaire.php');
						$req = $bdd->prepare('SELECT idUtilisateur FROM utilisateurs WHERE nomUtilisateur = ?');
						$req->execute(array($nomUtilisateur));
						$resultat = $req->fetch();
						if(!$resultat){
							$insertBDD = $bdd->prepare("INSERT INTO utilisateurs(nomUtilisateur,mdpUtilisateur,email,cleActivation,actif) VALUES (?,?,?,?,?)");
							$insertBDD->execute(array($nomUtilisateur,$motDePasse,$adresseMail,$cle, $activation));
							$header="MIME-Version: 1.0\r\n";
							$header.='From:"aos.itinet.fr"<support@aos.itinet.fr>'."\n";
							$header.='Content-Type:text/html; charset="utf-8"'."\n";
							$header.='Content-Transfert-Encoding: 8bit';

							$message='
							<html>
								<body>
									<div align="center">
										<a href="http://aos.itinet.fr/index.php?p=validation&utilisateur='.urlencode($nomUtilisateur).'&cle='.$cle.'">Confirmation du compte</a>
									</div>
								</body>
							</html>
							';

							mail($adresseMail, "Confirmation de compte", $message, $header);
							$messConfInscription = "Votre compte à bien été créer !";
						} else {
							$messErreurInscription = "Votre nom d'utilisateur existe déjà !";
						}
					} else {
						$messErreurInscription = "Vos mot de passe ne correspondent pas !";
					}
			} else {
				$messErreurInscription = "Vos adresse email ne correspondent pas !";
			}
		} else {
			$messErreurInscription = "Votre pseudo ne doit pas dépasser 20 caractères !";
		}	
	} else {
		$messErreurInscription = "Tous les champs doivent être remplis !";
	}
}
?>