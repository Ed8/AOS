<?php
	session_start();
	$_SESSION["nomUtilisateur"];
	include './connexionBdd.php';
	
	//Requete Table utilisateurs
	$req = $bdd->prepare("SELECT * FROM utilisateurs WHERE nomUtilisateur = ".$_SESSION["nomUtilisateur"]."");
	$req->execute();
	while ($data = $req->fetch()) {
		//echo $data['idUtilisateur'].$data['nomUtilisateur'];
		$_SESSION['idUtilisateur'] = $data['idUtilisateur'];
		//echo '<br/>';
	}
	
	//Requete Table domaines
	$req = $bdd->prepare("SELECT * FROM domaines WHERE idUtilisateur = ".$_SESSION['idUtilisateur']."");
	$req->execute();
	while ($data = $req->fetch()) {
		//echo $data['idDomaine'].$data['domaine'].$data['idUtilisateur'];
		$domaine[] = $data['domaine'];
		$_SESSION['idDomaine'] = $data['idDomaine'];
		//echo '<br/>';
	}
	
	//Requete Table enregistrements
	$req = $bdd->prepare("SELECT * FROM enregistrements WHERE idDomaine = ".$_SESSION['idDomaine']."");
	$req->execute();
	while ($data = $req->fetch()) {
		//echo $data['idEnreg'].$data['nomEnreg'].$data['typeEnreg'].$data['adresseIp'].$data['idDomaine'];
		$_SESSION['idEnreg'] = $data['idEnreg'];
		$_SESSION['adresseIp'] = $data['adresseIp'];
		$_SESSION['nomEnreg'] = $data['nomEnreg'];
		//echo $_SESSION['idEnreg'];
		//echo '<br/>';
	}
	
	if (isset($_SESSION['idEnreg'])) {
		//Requete Table servicesweb
		$req = $bdd->prepare("SELECT * FROM servicesWeb WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		while ($data = $req->fetch()) {
			//echo $data['idWeb'].$data['publicAvailable'].$data['publicEnabled'].$data['publicBdd'].$data['devAvailable'].$data['devEnabled'].$data['devBdd'].$data['idEnreg'];
			$pub[] = $data['publicAvailable'];
			$pub[] = $data['publicEnabled'];
			$pub[] = $data['publicBdd'];
			$dev[] = $data['devAvailable'];
			$dev[] = $data['devEnabled'];
			$dev[] = $data['devBdd'];
		}
	}
	
	if (isset($pub) && isset($dev) && $pub[0] == "0" && $dev[0] == "0") {
		$req = $bdd->prepare("DELETE FROM servicesWeb WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		
		$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
	}
?>
