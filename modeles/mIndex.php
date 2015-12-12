<?php

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
						$longueurCle = 12;
						$cle = "";
						for($i=1; $i<$longueurCle; $i++){
							$cle .= mt_rand(0,9);
						}
						require('connexionBdd.php');
						$insertBDD = $bdd->prepare("INSERT INTO utilisateurs(nomUtilisateur,mdpUtilisateur,email,cleActivation) VALUES (?,?,?,?)");
						$insertBDD->execute(array($nomUtilisateur,$motDePasse,$adresseMail,$cle));
						$header="MIME-Version: 1.0\r\n";
						$header.='From:"aos.itinet.fr"<support@aos.itinet.fr>' "\n";
						$header.='Content-Type:text/html; charset="utf-8"' "\n";
						$header.='Content-Transfert-Encoding: 8bit';

						$message='
						<html>
							<body>
								<div align="center">
									<a href="">Confirmation du compte</a>
								</div>
							</body>
						</html>
						';

						mail($mail, "Confirmation de compte", $message, $header);
						$erreur = "Votre compte à bien été créer";
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