<?php
	session_start();
	$_SESSION["nomUtilisateur"];
	if(!isset($_SESSION['idUtilisateur'])){
        header('Location: index.php');
    }
	include './connexionBdd.php';
	
	//SELECT idUtilisateur, les FQDN et services web activés dans AOS
	if (isset($_SESSION["nomUtilisateur"])) {
		$req = $bdd->prepare("SELECT idUtilisateur, actifFqdn, fqdn, fqdnDev, publicAvailableAos, publicEnabledAos, publicBddAos, devAvailableAos, devEnabledAos, devBddAos FROM utilisateurs WHERE nomUtilisateur = '".$_SESSION["nomUtilisateur"]."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idUtilisateur = $data['idUtilisateur'];
			$actifFqdn = $data['actifFqdn'];
			$fqdnAos = $data['fqdn'];
			$fqdnDev = $data['fqdnDev'];
			$publicAvailableAos = $data['publicAvailableAos'];
			$publicEnabledAos = $data['publicEnabledAos'];
			$publicBddAos = $data['publicBddAos'];
			$devAvailableAos = $data['devAvailableAos'];
			$devEnabledAos = $data['devEnabledAos'];
			$devBddAos = $data['devBddAos'];
		}
	}
	
	//SELECT idDomaine et les domaines de l'utilisateur
	if (isset($idUtilisateur)) {
		$req = $bdd->prepare("SELECT idDomaine, domaine FROM domaines WHERE idUtilisateur = '".$idUtilisateur."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$idDomaine = $data['idDomaine'];
			$domaine[] = $data['domaine'];
		}
	}
	
	//SELECT  les idEnregistrement et les enregistrements de l'utilisateur
	$req = $bdd->prepare("SELECT nomEnreg, idEnreg FROM enregistrements JOIN domaines ON enregistrements.idDomaine = domaines.idDomaine JOIN utilisateurs ON domaines.idUtilisateur = utilisateurs.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."' AND adresseIp = '88.177.168.133' AND typeEnreg = 'fqdn'");
	$req->execute();
	while ($data = $req->fetch()) {
		$nomEnreg[] = $data['nomEnreg'];
		$idEnregistrement[] = $data['idEnreg'];
	}
	
	$req = $bdd->prepare("SELECT nomEnreg, idEnreg FROM enregistrements JOIN domaines ON enregistrements.idDomaine = domaines.idDomaine JOIN utilisateurs ON domaines.idUtilisateur = utilisateurs.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."' AND adresseIp = '88.177.168.133' AND typeEnreg = 'fqdn' AND web = '0'");
	$req->execute();
	while ($data = $req->fetch()) {
		$nomEnregWeb[] = $data['nomEnreg'];
		$idEnregistrementWeb[] = $data['idEnreg'];
	}
	
	//SELECT  idEnreg et les services web dans domaine externe
	if (isset($_SESSION['nomUtilisateur'])) {
		$req = $bdd->prepare("SELECT * FROM servicesWeb JOIN enregistrements ON enregistrements.idEnreg = servicesWeb.idEnreg JOIN domaines ON domaines.idDomaine = enregistrements.idDomaine JOIN utilisateurs ON utilisateurs.idUtilisateur = domaines.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$number = 0;
		while ($data = $req->fetch()) {
			$pubAvailable[$number] = $data['available'];
			$pubEnabled[$number] = $data['enabled'];
			$pubBdd[$number] = $data['bdd'];
			$fqdn[$number] = $data['nomEnreg'];
			$idEnreg[$number] = $data['idEnreg'];
			$number = $number + 1;
		}
	}
	
	//Récup Fqdn et Domaine externe
	function verifFqdn($a)
	{
		$ex = explode(".",$a);
		$nb = count($ex);
		if ($nb == 2) {
			$argTemp1 = "";
			$argTemp2 = $ex[0].".".$ex[1];
		} elseif ($nb > 2) {
			$compter = $nb - 2;
			$nbCel = 0;
			$argu = "";
			for ($i = 0; $i < $compter; $i++) {
				$arg1[$nbCel] = ".".$ex[$i];
				if ($nbCel > 0) {
					$argu = $argu.$arg1[$nbCel];
				}
				$nbCel = $nbCel + 1;
			}
			$ex1 = explode(".", $arg1[0]);
			$argTemp1 = $ex1[1].$argu;
			$compter1 = $nb - $compter;
			$nbCel1 = 0;
			for ($j = $compter; $j < $nb; $j++) {
				$arg[$nbCel1] = ".".$ex[$j];
				$nbCel1 = $nbCel1 + 1;
			}
			$ex2 = explode(".", $arg[0]);
			$argTemp2 = $ex2[1].$arg[1];
		}
		return array($argTemp1, $argTemp2);
	}
	
	//Récup fqdn aos.itinet.fr
	function verifAosFqdn($a)
	{
		$exi = explode(".",$a);
		$nb = count($exi);
		$compteur = $nb - 3;
		$nbCellule = 0;
		$argu = "";
		for ($i = 0; $i < $compteur; $i++) {
			$arg1[$nbCellule] = ".".$exi[$i];
			if ($nbCellule > 0) {
				$argu = $argu.$arg1[$nbCellule];
			}
			$nbCellule = $nbCellule + 1;
		}
		$exi1 = explode(".", $arg1[0]);
		$argTemp1 = $exi1[1].$argu;
		return $argTemp1;
	}
	
	//Met actifFqdn si fqdn et fqdnDev sont null
	if (empty($fqdnAos) && empty($fqdnDev) && $actifFqdn == 1 ) {
		$req = $bdd->prepare("UPDATE utilisateurs SET actifFqdn = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		header('Location: index.php?p=web');
	}
	
	//#################################################################################################################
	
	if (isset($_POST['createAos'])) {
		$aosfqdnchars = htmlspecialchars($_POST['aosFqdn']);
		$req = $bdd->prepare("SELECT fqdn FROM utilisateurs WHERE fqdn = '".$aosfqdnchars.".aos.itinet.fr'");
		$req->execute();
		while ($data = $req->fetch()) {
			$verifFqdnAos = $data['fqdn'];
		}
		if (empty($aosfqdnchars)) {
			$error = "Le champs de saisie ne doit pas être vide !";
		} elseif (empty($verifFqdnAos)) {			
			if (isset($_POST['aosBdd']) && $_POST['aosBdd'] == "add") {
				$publicBddAos = '1';
				$replace = str_replace('.', '_', $aosfqdnchars);
				$database = $replace;
				shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' aos_itinet_fr');
			} else {
				$publicBddAos = '0';
			}
			$aosFqdn = $aosfqdnchars.".aos.itinet.fr";
			$req = $bdd->prepare("UPDATE utilisateurs SET actifFqdn = 1, fqdn = '".$aosFqdn."', publicAvailableAos = 1, publicEnabledAos = 1, publicBddAos = '".$publicBddAos."' WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
			$req->execute();
			shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
			shell_exec('/var/www/aos/script/addPublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$aosfqdnchars.' aos.itinet.fr');
			shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$aosfqdnchars.' aos.itinet.fr');
			shell_exec('sudo bash /var/www/aos/script/addenregzone.sh '.$aosfqdnchars.' aos.itinet.fr fqdn 88.177.168.133');
			header('Location: index.php?p=web');	
		} else {
			$error = "Ce FQDN existe déjà veuillez en choisir un autre !";
		}
	} elseif (isset($_POST['createDevAos'])) {
		$devFqdnAos = "dev.".$fqdnAos;
		$verifAosFqdn = verifAosFqdn($devFqdnAos);
		$verification = verifAosFqdn($fqdnAos);
		$plode = explode(".", $verifAosFqdn, 2);
		if (isset($_POST["aosDevBdd"]) && $_POST["aosDevBdd"] == "add") {
			$devBdd = '1';
			$replace = str_replace('.', '_', $verification);
			$database = $replace;
			 shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' aos_itinet_fr');
		} else {
			$devBdd = '0';
		}
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = '".$devFqdnAos."', devAvailableAos = 1, devBddAos = ".$devBdd.", devEnabledAos = 1  WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/addDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$plode[1].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$plode[1].' aos.itinet.fr');
		shell_exec('sudo bash /var/www/aos/script/addenregzone.sh '.$verifAosFqdn.' aos.itinet.fr fqdn 88.177.168.133');
		header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createDomaine'])) {
		$fqdndomainechars = htmlspecialchars($_POST['fqdnDomaine']);
		if (empty($fqdndomainechars)) {
				$fqdnDomaine = $_POST['domaine'];
				$ex[0] = '';
				$ex[1] = $fqdnDomaine;
		} else {
				$fqdnDomaine = $fqdndomainechars.".".$_POST['domaine'];
				$ex[0] = $fqdndomainechars.".";
				$ex[1] = $_POST['domaine'];
		}
		$req = $bdd->prepare("SELECT nomEnreg FROM enregistrements WHERE nomEnreg = '".$fqdnDomaine."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$verifFqdnDomaine = $data['nomEnreg'];
		}
		
		if (empty($verifFqdnDomaine)) {
			if (isset($_POST['domaineBdd']) && $_POST['domaineBdd'] == "add") {
				$publicBdd = '1';
				$replace = str_replace('.', '_', $ex[0]);
				$database = $replace;
				$replace = str_replace('.', '_', $ex[1]);
				$database1 = $replace;
				shell_exec('/var/www/aos/script/addDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' '.$database1.'');
			} elseif (!isset($_POST['domaineBdd'])) {
				$publicBdd = '0';
			}	
			$req = $bdd->prepare("SELECT idDomaine FROM domaines WHERE domaine = '".$_POST['domaine']."'");
			$req->execute();
			while ($data = $req->fetch()) {
				$idDomaineExterne = $data['idDomaine'];
			}
			$req = $bdd->prepare("INSERT INTO enregistrements(nomEnreg, typeEnreg, adresseIp, idDomaine, web) VALUES (?,?,?,?,?)");
			$req->execute(array($fqdnDomaine, "fqdn", "88.177.168.133", $idDomaineExterne, "1"));	
			$enregNom = $fqdnDomaine;
			$req = $bdd->prepare("SELECT idEnreg FROM enregistrements WHERE nomEnreg = '".$enregNom."'");
			$req->execute();
			while ($data = $req->fetch()) {
				$idEnregDomaine = $data['idEnreg'];
			}
			$req = $bdd->prepare("INSERT INTO servicesWeb(available, enabled, bdd, idEnreg) VALUES(?,?,?,?)");
			$req->execute(array("1", "1", $publicBdd, $idEnregDomaine));
			shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
			shell_exec('/var/www/aos/script/addWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' '.$ex[1].'');
			shell_exec('/var/www/aos/script/enableWebSite.sh '.$ex[0].' '.$ex[1].'');
			if (empty($fqdndomainechars)) {
				$ex[0] = '0';
			} else {
				$ex[0] = $fqdndomainechars;
			}
			shell_exec('sudo bash /var/www/aos/script/addenregzone.sh '.$ex[0].' '.$ex[1].' fqdn 88.177.168.133');
			header('Location: index.php?p=web');
		} else {
			$errorDomaine = "Ce FQDN existe déjà veuillez en choisir un autre !";
		}	
	
	} elseif (isset($_POST['publicAos'])) {
		if (isset($fqdnDev)) {
			$verifAosFqdn = verifAosFqdn($fqdnDev);
			$xpl = explode('.', $verifAosFqdn, 2);
			$verifAosFqdn = $xpl[1];
			
			$backFqdn = explode('.', $fqdnDev, 2);
			$fqdnAos = $backFqdn[1];
		}
		if (isset($_POST["aosBdd"]) && $_POST["aosBdd"] == "add") {
			$devBdd = '1';
			$replace = str_replace('.', '_', $verifAosFqdn);
			$database = $replace;
			shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' aos_itinet_fr');
		} else {
			$devBdd = '0';
		}
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdn = '".$fqdnAos."', publicAvailableAos = 1, publicBddAos = ".$devBdd.", publicEnabledAos = 1  WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();		
		shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		shell_exec('/var/www/aos/script/addPublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$verifAosFqdn.' aos.itinet.fr');
		shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$verifAosFqdn.' aos.itinet.fr');
		shell_exec('sudo bash /var/www/aos/script/addenregzone.sh '.$verifAosFqdn.' aos.itinet.fr fqdn 88.177.168.133');
		header('Location: index.php?p=web');
	} 
	
	//###########################################################################
	//	AOS
	//###########################################################################
	
	if (isset($_POST['pubActiverWebAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnAos);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$verifAosFqdn.' aos.itinet.fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverWebAos'])) {
		// $ex = explode(".", $fqdnAos, 2);
		$verifAosFqdn = verifAosFqdn($fqdnAos);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$verifAosFqdn.' aos.itinet.fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubActiverBddAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnAos);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $verifAosFqdn);
		$database = $replace;
		shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' aos_itinet_fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverBddAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnAos);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $verifAosFqdn);
		$database = $replace;
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$database.' aos_itinet_fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubSupWebAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnAos);
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdn = NULL, publicAvailableAos = 0, publicEnabledAos = 0, publicBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $verifAosFqdn);
		$database = $replace;
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$database.' aos_itinet_fr');
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$verifAosFqdn.' aos.itinet.fr');
		shell_exec('/var/www/aos/script/deletePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$verifAosFqdn.' aos.itinet.fr');
		shell_exec('sudo bash /var/www/aos/script/delzone.sh '.$verifAosFqdn.' aos.itinet.fr fqdn 88.177.168.133');
		
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverWebAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnDev);
		$exDev = explode(".", $verifAosFqdn, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$exDev[1].' aos.itinet.fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverWebAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnDev);
		$exDev = explode(".", $verifAosFqdn, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$exDev[1].' aos.itinet.fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverBddAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnDev);
		$exDev = explode(".", $verifAosFqdn, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $exDev[1]);
		$database = $replace;
		shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION['nomUtilisateur'].' '.$database.' aos_itinet_fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverBddAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnDev);
		$exDev = explode(".", $verifAosFqdn, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $exDev[1]);
		$database = $replace;
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$database.' aos_itinet_fr');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devSupWebAos'])) {
		$verifAosFqdn = verifAosFqdn($fqdnDev);
		$exDev = explode(".", $verifAosFqdn, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = NULL, devAvailableAos = 0, devEnabledAos = 0, devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		$replace = str_replace('.', '_', $exDev[1]);
		$database = $replace;
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$database.' aos_itinet_fr');
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$exDev[1].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/deleteDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$exDev[1].' aos.itinet.fr');
		shell_exec('sudo bash /var/www/aos/script/delzone.sh dev.'.$exDev[1].' aos.itinet.fr fqdn 88.177.168.133');
		header('Location: index.php?p=web');
	}
	
	//###########################################################################
	//		EXTERNE
	//###########################################################################
	
	if (isset($pubAvailable)) {
		$nb = count($pubAvailable);
		for ($i = 0; $i < $nb; $i++) {
			$verifFqdn = verifFqdn($fqdn[$i]);
			if ($verifFqdn[0] !== "") {
				$verifFqdn[0] = $verifFqdn[0].".";
			} else {
				$verifFqdn[0] = 0;
			}
			
			if (isset($_POST['pubactiverweb'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET enabled = 1 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/enableWebSite.sh '.$verifFqdn[0].' '.$verifFqdn[1].'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubdesactiverweb'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET enabled = 0 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/disableWebSite.sh '.$verifFqdn[0].' '.$verifFqdn[1].'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubactiverbdd'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET bdd = 1 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				$replace = str_replace('.', '_', $verifFqdn[0]);
				$database = $replace;				
				$replace = str_replace('.', '_', $verifFqdn[1]);
				$database1 = $replace;
				shell_exec('/var/www/aos/script/addDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$database.' '.$database1.'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubdesactiverbdd'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET bdd = 0 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				$replace = str_replace('.', '_', $verifFqdn[0]);
				$database = $replace;
				$replace = str_replace('.', '_', $verifFqdn[1]);
				$database1 = $replace;
				shell_exec('/var/www/aos/script/deleteDatabase.sh '.$database.' '.$database1.'');
				header('Location: index.php?p=web');
			}
	
	
			if (isset($_POST['pubsupweb'.$i.''])) {
				$req = $bdd->prepare("DELETE FROM servicesWeb WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				$replace = str_replace('.', '_', $verifFqdn[0]);
				$database = $replace;
				$replace = str_replace('.', '_', $verifFqdn[1]);
				$database1 = $replace;
				shell_exec('/var/www/aos/script/deleteDatabase.sh '.$database.' '.$database1.'');
				shell_exec('/var/www/aos/script/disableWebSite.sh '.$verifFqdn[0].' '.$verifFqdn[1].'');
				shell_exec('/var/www/aos/script/deleteWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$verifFqdn[0].' '.$verifFqdn[1].'');
				
				if ($verifFqdn[0] == "") {
					$verifFqdn[0] = 0;
				} else {
					$lode = explode(".",$verifFqdn[0], 2);
					$verifFqdn[0] = $lode[0];
				}
				shell_exec('sudo bash /var/www/aos/script/delzone.sh '.$verifFqdn[0].' '.$verifFqdn[1].' fqdn 88.177.168.133');
				header('Location: index.php?p=web');
			}
		}
	}
	
	if (isset($nomEnregWeb)) {
		// var_dump($nomEnregWeb);
		$nbWeb = count($nomEnregWeb);
		for ($i = 0; $i < $nbWeb; $i++) {
			$verifFqdn = verifFqdn($nomEnregWeb[$i]);
			if ($verifFqdn[0] !== "") {
				$verifFqdn[0] = $verifFqdn[0].".";
			} else {
				$verifFqdn[0] = 0;
			}
			
			if (isset($_POST['activerWeb'.$i.''])) {
				$req = $bdd->prepare("UPDATE enregistrements SET web = 1 WHERE idEnreg = '".$idEnregistrementWeb[$i]."'");
				$req->execute();
				$req = $bdd->prepare("INSERT INTO servicesWeb(available, enabled, bdd, idEnreg) VALUES(?,?,?,?)");
				$req->execute(array("1", "1", "0", $idEnregistrementWeb[$i]));
				shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
				shell_exec('/var/www/aos/script/addWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$verifFqdn[0].' '.$verifFqdn[1].'');
				shell_exec('/var/www/aos/script/enableWebSite.sh '.$verifFqdn[0].' '.$verifFqdn[1].'');
				header('Location: index.php?p=web');
			}
			if (isset($_POST['supWeb'.$i.''])) {
				$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = '".$idEnregistrementWeb[$i]."'");
				$req->execute();
				if ($verifFqdn[0] == "") {
					$verifFqdn[0] = 0;
				} else {
					$lod = explode(".",$verifFqdn[0], 2);
					$verifFqdn[0] = $lod[0];
				}
				shell_exec('sudo bash /var/www/aos/script/delzone.sh '.$verifFqdn[0].' '.$verifFqdn[1].' fqdn 88.177.168.133');
				header('Location: index.php?p=web');
			}
		}
	}
?>