<?php
	session_start();
	$_SESSION["nomUtilisateur"];
	if(!isset($_SESSION['idUtilisateur'])){
        header('Location: index.php');
    }
	include './connexionBdd.php';
	
	
	if (isset($_SESSION["nomUtilisateur"])) {
		$req = $bdd->prepare("SELECT actifFqdn, fqdn, publicAvailableAos, publicEnabledAos, publicBddAos, devAvailableAos, devEnabledAos, devBddAos FROM utilisateurs WHERE nomUtilisateur = '".$_SESSION["nomUtilisateur"]."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$actifFqdn = $data['actifFqdn'];
			$fqdnAos = $data['fqdn'];
			$publicAvailableAos = $data['publicAvailableAos'];
			$publicEnabledAos = $data['publicEnabledAos'];
			$publicBddAos = $data['publicBddAos'];
			$devAvailableAos = $data['devAvailableAos'];
			$devEnabledAos = $data['devEnabledAos'];
			$devBddAos = $data['devBddAos'];
		}
	}
	
	if (isset($_SESSION["nomUtilisateur"])) {
		//utilisateurs
		$req = $bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idUtilisateur = $data['idUtilisateur'];
			// echo $idUtilisateur;
		}
	}
	
	if (isset($idUtilisateur)) {
		//domaines
		$req = $bdd->prepare("SELECT idDomaine, domaine FROM domaines WHERE idUtilisateur = '".$idUtilisateur."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idDomaine = $data['idDomaine'];
			$domaine[] = $data['domaine'];
			// echo $idDomaine;
		}
		//var_dump($domaine);
	}
	
		//enregistrements
		$req = $bdd->prepare("SELECT nomEnreg FROM enregistrements JOIN domaines ON enregistrements.idDomaine = domaines.idDomaine JOIN utilisateurs ON domaines.idUtilisateur = utilisateurs.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."' AND adresseIp = '88.177.168.133'");
		$req->execute();
		while ($data = $req->fetch()) {
			$nomEnreg[] = $data['nomEnreg'];
		}
		//var_dump($nomEnreg);
	//}
	
	if (isset($_SESSION['nomUtilisateur'])) {
		//servicesWeb
		$req = $bdd->prepare("SELECT * FROM servicesWeb JOIN enregistrements ON enregistrements.idEnreg = servicesWeb.idEnreg JOIN domaines ON domaines.idDomaine = enregistrements.idDomaine JOIN utilisateurs ON utilisateurs.idUtilisateur = domaines.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$pubAvailable = $data['publicAvailable'];
			$pubEnabled = $data['publicEnabled'];
			$pubBdd = $data['publicBdd'];
			$devAvailable = $data['devAvailable'];
			$devEnabled = $data['devEnabled'];
			$devBdd = $data['devBdd'];
			$fqdn = $data['nomEnreg'];
			$idEnreg = $data['idEnreg'];
		}
	}
	
	if (isset($pubAvailable) && isset($devAvailable) && $pubAvailable == "0" && $devAvailable == "0") {
		$req = $bdd->prepare("DELETE FROM servicesWeb WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		
		header('Location: index.php?p=web');
	}
	//#################################################################################################################
	
	if (isset($_POST['createAos'])) {
		
		if ($_POST['aosBdd'] == "add") {
			$publicBddAos = '1';
			// shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} else {
			$publicBddAos = '0';
		}
		
		if ($actifFqdn !== "1") {

			$aosFqdn = $_POST['aosFqdn'].".aos.itinet.fr";
			$req = $bdd->prepare("UPDATE utilisateurs SET actifFqdn = 1, fqdn = '".$aosFqdn."', publicAvailableAos = 1, publicEnabledAos = 1, publicBddAos = '".$publicBddAos."' WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
			$req->execute();
			
			shell_exec("var/www/aos/script/addenregzone.sh '".$aosFqdn."' 'aos.itinet.fr'  'fqdn' '88.177.168.133'");
			
		} elseif ($actifFqdn == "1" && $publicAvailableAos !== "1") {
			
			$req = $bdd->prepare("UPDATE utilisateurs SET publicAvailableAos = 1, publicEnabledAos = 1, publicBddAos = '".$publicBddAos."' WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
			$req->execute();
		}
		
		// shell_exec("/var/www/aos/script/addRepositoryWebSites.sh '".$aosFqdn."'");
		// shell_exec("/var/www/aos/script/addPublicWebSite.sh '".$aosFqdn."' aos.itinet.fr");
		
		header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createDevAos'])) {
		
		// shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		// shell_exec('/var/www/aos/script/addDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['aosFqdn'].'');
		
		if ($_POST["aosDevBdd"] == "add") {
			$devBdd = '1';
			// shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} else {
			$devBdd = '0';
		}
		
		$devFqdnAos = "dev.".$fqdnAos;
		
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = '".$devFqdnAos."', devAvailableAos = 1, devBddAos = ".$devBdd.", devEnabledAos = 1  WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		
		shell_exec("var/www/aos/script/addenregzone.sh 'dev.".$aosFqdn."' 'aos.itinet.fr'  'fqdn' '88.177.168.133'");
		
		header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createDomaine'])) {
		
		if (isset($_POST['domaineBdd']) && $_POST['domaineBdd'] == "add") {
			$publicBdd = '1';
			// shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} elseif (!isset($_POST['domaineBdd'])) {
			$publicBdd = '0';
		}
		
		// shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		
		
		if (isset($_POST['fqdnDomaine'])) {
			
			$req = $bdd->prepare("SELECT idDomaine FROM domaines WHERE domaine = '".$_POST['domaine']."'");
			$req->execute();
			while ($data = $req->fetch()) {
				$idDomaineExterne = $data['idDomaine'];
			}
			
			$fqdnDomaine = $_POST['fqdnDomaine'].".".$_POST['domaine'];
			$req = $bdd->prepare("INSERT INTO enregistrements(nomEnreg, typeEnreg, adresseIp, idDomaine) VALUES (?,?,?,?)");
			$req->execute(array($fqdnDomaine, "fqdn", "88.177.168.133", $idDomaineExterne));	
			
			$enregNom = $fqdnDomaine;
			
			shell_exec("var/www/aos/script/addenregzone.sh '".$_POST['fqdnDomaine']."' '".$_POST['domaine']."' 'fqdn' '88.177.168.133'");
			
		} else {
			$enregNom = $_POST['domaine'];
			
			$part = explode(".", $enregNom);
			echo $part[0];
			echo $part[1];
			echo $part[2];
			
			$enreg = $part[0];
			$dom = $part[1].".".$part[2];
			
			shell_exec("var/www/aos/script/addenregzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133'");
		}
		
		$req = $bdd->prepare("SELECT idEnreg FROM enregistrements WHERE nomEnreg = '".$enregNom."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idEnregDomaine = $data['idEnreg'];
		}
		
		$req = $bdd->prepare("INSERT INTO servicesWeb(publicAvailable, publicEnabled, publicBdd, devAvailable, devEnabled, devBdd, idEnreg) VALUES(?,?,?,?,?,?,?)");
		$req->execute(array("1", "1", $publicBdd, "0", "0", "0", $idEnregDomaine));
	
		
		// shell_exec("/var/www/aos/script/addRepositoryWebSites.sh '".$aosFqdn."'");
		// shell_exec("/var/www/aos/script/addPublicWebSite.sh '".$aosFqdn."' aos.itinet.fr");
		
		//header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createDev'])) {
		
		$req = $bdd->prepare("SELECT idEnreg FROM enregistrements WHERE nomEnreg = '".$fqdn."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idEnregDomaine2 = $data['idEnreg'];
		}
		
		// shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		// shell_exec('/var/www/aos/script/addDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['aosFqdn'].'');
		
		if ($_POST["DevBdd"] == "add") {
			$devBdd = '1';
			// shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		} else {
			$devBdd = '0';
		}
		
		$part = explode(".", $fqdn);
		echo $part[0];
		echo $part[1];
		echo $part[2];
		
		$enreg = $part[0];
		$dom = $part[1].".".$part[2];
		
		shell_exec("var/www/aos/script/addenregzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133'");
		
		$req = $bdd->prepare("UPDATE servicesWeb SET devAvailable = 1, devBdd = ".$devBdd.", devEnabled = 1  WHERE idEnreg = '".$idEnregDomaine2."'");
		$req->execute();
		
		header('Location: index.php?p=web');
		
	}
	
	//###########################################################################
	//	AOS
	//###########################################################################
	
	if (isset($_POST['pubActiverWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubActiverBddAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverBddAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubSupWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdn = NULL, fqdnDev = NULL, actifFqdn = 0, publicAvailableAos = 0, publicEnabledAos = 0, publicBddAos = 0, devAvailableAos = 0, devEnabledAos = 0, devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deletePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		
		$part = explode(".", $fqdnAos);
		echo $part[0];
		echo $part[1];
		echo $part[2];
		
		$enreg = $part[0];
		$dom = $part[1].".".$part[2];
		
		shell_exec("/var/www/aos/script/delzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133' ");
		
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverBddAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverBddAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devSupWebAos'])) {
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = NULL, devAvailableAos = 0, devEnabledAos = 0, devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deleteDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		
		$part = explode(".", $fqdnAos);
		echo $part[0];
		echo $part[1];
		echo $part[2];
		
		$enreg = "dev.".$part[0];
		$dom = $part[1].".".$part[2];
		
		shell_exec("/var/www/aos/script/delzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133' ");
		
		
		
		header('Location: index.php?p=web');
	}
	
	//###########################################################################
	//		EXTERNE
	//###########################################################################
	
	if (isset($_POST['pubactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicEnabled = 1 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubdesactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicEnabled = 0 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicBdd = 1 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubdesactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET publicBdd = 0 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubsupweb'])) {
		$req = $bdd->prepare("DELETE FROM servicesWeb WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		
		$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deletePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		
		$part = explode(".", $fqdn);
		echo $part[0];
		echo $part[1];
		echo $part[2];
		
		$enreg = $part[0];
		$dom = $part[1].".".$part[2];
		
		shell_exec("/var/www/aos/script/delzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133' ");
		
		
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devEnabled = 1 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devdesactiverweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devEnabled = 0 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devBdd = 1 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devdesactiverbdd'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devBdd = 0 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devsupweb'])) {
		$req = $bdd->prepare("UPDATE servicesWeb SET devAvailable = 0, devEnabled = 0, devBdd = 0 WHERE idEnreg = '".$idEnreg."'");
		$req->execute();
		// shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deleteDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$_SESSION['domaine'].'');
		// shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$_SESSION["nomUtilisateur"].'');
		
		$part = explode(".", $fqdn);
		echo $part[0];
		echo $part[1];
		echo $part[2];
		
		$enreg = "dev.".$part[0];
		$dom = $part[1].".".$part[2];
		
		shell_exec("/var/www/aos/script/delzone.sh '".$enreg."' '".$dom."' 'fqdn' '88.177.168.133' ");
		
		header('Location: index.php?p=web');
	}
?>