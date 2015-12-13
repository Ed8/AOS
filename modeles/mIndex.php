<?php
//Inscription modal

if(isset($_POST['confInscription'])){
	$nomUtilisateur=htmlspecialchars($_POST['nomUtilisateur']);
	$adresseMail=htmlspecialchars($_POST['mail']);
	$confMail=htmlspecialchars($_POST['confMail']);
	$motDePasse=sha1($_POST['motDePasse']);
	$confMotDePasse=sha1($_POST['confMotDePasse']);
	
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
						require('connexionBdd.php');
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
							$erreur = "Votre compte à bien été créer";
						} else {
							$erreur = "Votre nom d'utilisateur existe déjà";
						}
					} else {
						$erreur = "Vos mot de passe ne correspondent pas !";
					}
			} else {
				$erreur = "Vos adresse email ne correspondent pas !";
			}
		} else {
			$erreur = "Votre pseudo ne doit pas dépasser 20 caractères";
		}	
	} else {
		$erreur = "Tous les champs doivent être remplis";
	}
}
?>
//Connexion modal
<?php
require('connexionBdd.php');

if(isset($_POST['confConnexion'])){
	$nomUtilisateur = htmlspecialchars($_POST['nomUtilisateur']);
	$motDePasse = sha1($_POST['motDePasse']);
	
	if(!empty($nomUtilisateur) AND !empty($motDePasse)){
		$reqUtilisateur = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ? AND motDePasse = ?");
		$reqUtilisateur->execute(array($nomUtilisateur, $motDePasse));
		$utilisateurExist = $reqUtilisateur->rowCount();
		
		if($utilisateurExist == 1){
			$utilisateurInfo = $reqUtilisateur->fetch();
			session_start();
			$_SESSION['idUtilisateur'] = $utilisateurInfo['idUtilisateur'];
			$_SESSION['nomUtilisateur'] = $utilisateurInfo['nomUtilisateur'];
			header("Location: index.php?p=indexUtilisateur&id=".$_SESSION['idUtilisateur']);

		} else {
			$erreur = "Mauvais nom d'utilisateur ou mot de passe !";
		}
	} else {
		$erreur = "Tous les champs doivent être complétés !":
	}
}
?>
