<?php
	if (isset($_POST['createpub'])) {
		$_SESSION['fqdn'] = $_POST['fqdn'].".".$_POST['domaine'];
		$fqdn = $_SESSION['fqdn'];
		$_SESSION['domaine'] = $_POST['domaine'];
		
		
		$req = $bdd->prepare("SELECT idDomaine FROM domaines WHERE domaine = '".$_POST['domaine']."'");
		$req->execute();
		$result = $req->fetchAll();
		$idDomaine = $result[0][0];
		
		$req = $bdd->prepare("SELECT idEnreg FROM enregistrements WHERE idDomaine = '$idDomaine'");
		$req->execute();
		$result = $req->fetchAll();
		
		$publicAvailable = '1';
		$devAvailable = '0';
		$devBdd = '0';
		$devEnabled = '0';
		
		shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		shell_exec('/var/www/aos/script/addPublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		
		if ($_POST['bdd'] == "add") {
			$publicBdd = '1';
			shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} else {
			$publicBdd = '0';
		}
		
		if ($_POST['activ'] == "enabled") {
			$publicEnabled = '1';
			shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		} else {
			$publicEnabled = '0';
		}
		
		$req = $bdd->prepare("INSERT INTO enregistrements(nomEnreg, typeEnreg, adresseIp, idDomaine)VALUES(?, ?, ?, ?)");
		$req->execute(array($_SESSION['fqdn'], 'a', '88.177.168.133', $_SESSION['idDomaine']));
		
		echo "yalaaaaaaaaaaaaa";
		
		$req = $bdd->prepare("SELECT idEnreg FROM enregistrements WHERE idDomaine = ".$_SESSION['idDomaine']."");
		$req->execute();
		while ($data = $req->fetch()) {
			echo $data['idEnreg']."yolooooooooo";
			$_SESSION['idEnregg'] = $data['idEnreg'];
		}
		
		echo "yiliiiiiiiiiiiiiiiiiiiiiiiiiii";
		
		$req = $bdd->prepare("INSERT INTO servicesWeb(publicAvailable, devAvailable, publicBdd, devBdd, publicEnabled, devEnabled, idEnreg)VALUES(?, ?, ?, ?, ?, ?, ?)");
		$req->execute(array($publicAvailable, $devAvailable, $publicBdd, $devBdd, $publicEnabled, $devEnabled, $_SESSION['idEnregg']));
		
		header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createdev'])) {
		
		shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		shell_exec('/var/www/aos/script/addDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		
		if ($_POST['bdd'] == "add") {
			$devBdd = '1';
			shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} else {
			$devBdd = '0';
		}
		
		if ($_POST['activ'] == "enabled") {
			$devEnabled = '1';
			shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		} else {
			$devEnabled = '0';
		}
		
		$req = $bdd->prepare("UPDATE servicesWeb SET devAvailable = 1, devBdd = ".$devBdd.", devEnabled = ".$devEnabled."  WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicEnabled = 1 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubdesactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicEnabled = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicBdd = 1 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubdesactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicBdd = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubsupweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicAvailable = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		shell_exec('/var/www/aos/script/deletePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devEnabled = 1 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devdesactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devEnabled = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devBdd = 1 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devdesactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devBdd = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devsupweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devAvailable = 0 WHERE idEnreg = ".$_SESSION['idEnreg']."");
		$req->execute();
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		shell_exec('/var/www/aos/script/deleteDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
?>
