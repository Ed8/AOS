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
	$req = $bdd->prepare("SELECT nomEnreg, idEnreg FROM enregistrements JOIN domaines ON enregistrements.idDomaine = domaines.idDomaine JOIN utilisateurs ON domaines.idUtilisateur = utilisateurs.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."' AND adresseIp = '88.177.168.133' and typeEnreg = 'fqdn'");
	$req->execute();
	while ($data = $req->fetch()) {
		$nomEnreg[] = $data['nomEnreg'];
		$idEnregistrement[] = $data['idEnreg'];
	}
	
	$req = $bdd->prepare("SELECT nomEnreg, idEnreg FROM enregistrements JOIN domaines ON enregistrements.idDomaine = domaines.idDomaine JOIN utilisateurs ON domaines.idUtilisateur = utilisateurs.idUtilisateur WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."' AND adresseIp = '88.177.168.133' and typeEnreg = 'fqdn' AND web IS NULL OR web = '0'");
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
				shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$aosfqdnchars.' aos.itinet.fr');
			} else {
				$publicBddAos = '0';
			}
				
			$aosFqdn = $aosfqdnchars.".aos.itinet.fr";
			$req = $bdd->prepare("UPDATE utilisateurs SET actifFqdn = 1, fqdn = '".$aosFqdn."', publicAvailableAos = 1, publicEnabledAos = 1, publicBddAos = '".$publicBddAos."' WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
			$req->execute();
			
			
			shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
			shell_exec('/var/www/aos/script/addPublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$aosfqdnchars.' aos.itinet.fr');
			shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$aosfqdnchars.' aos.itinet.fr');
			shell_exec('/var/www/aos/script/addenregzone.sh '.$aosfqdnchars.' aos.itinet.fr fqdn 88.177.168.133');
			
			header('Location: index.php?p=web');
			
		} else {
			$error = "Ce FQDN existe déjà veuillez en choisir un autre !";
		}
		
		
		
	} elseif (isset($_POST['createDevAos'])) {
		
		$devFqdnAos = "dev.".$fqdnAos;
		
		$ex = explode(".", $fqdnAos, 2);
		
		
		if (isset($_POST["aosDevBdd"]) && $_POST["aosDevBdd"] == "add") {
			$devBdd = '1';
			 shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' aos.itinet.fr');
		} else {
			$devBdd = '0';
		}
		
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = '".$devFqdnAos."', devAvailableAos = 1, devBddAos = ".$devBdd.", devEnabledAos = 1  WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		
		shell_exec('/var/www/aos/script/addDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$ex[0].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/addenregzone.sh dev.'.$ex[0].' aos.itinet.fr fqdn 88.177.168.133');
		
		header('Location: index.php?p=web');
		
	} elseif (isset($_POST['createDomaine'])) {
		
		$fqdndomainechars = htmlspecialchars($_POST['fqdnDomaine']);
		
		if (empty($fqdndomainechars)) {
				$fqdnDomaine = $_POST['domaine'];
				$ex[0] = '';
				$ex[1] = $fqdnDomaine;
		} else {
				$fqdnDomaine = $fqdndomainechars.".".$_POST['domaine'];
				$ex = explode(".", $fqdnDomaine, 2);
		}
		
		/*echo $fqdnDomaine."<br/>";
		echo $ex[0]."<br/>";
		echo $ex[1]."<br/>";*/
		
		$req = $bdd->prepare("SELECT nomEnreg FROM enregistrements WHERE nomEnreg = '".$fqdnDomaine."'");
		$req->execute();
		while ($data = $req->fetch()) {
			$verifFqdnDomaine = $data['nomEnreg'];
		}
		
		// echo $verifFqdnDomaine;
		
		if (empty($verifFqdnDomaine)) {
			
			if (isset($_POST['domaineBdd']) && $_POST['domaineBdd'] == "add") {
				$publicBdd = '1';
				shell_exec('/var/www/aos/script/addDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' .'.$ex[1].'');
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
			shell_exec('/var/www/aos/script/addWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' .'.$ex[1].'');
			shell_exec('/var/www/aos/script/enableWebSite.sh '.$ex[0].' .'.$ex[1].'');
			shell_exec('/var/www/aos/script/addenregzone.sh '.$ex[0].' '.$ex[1].' fqdn 88.177.168.133');
			
			header('Location: index.php?p=web');
			
		} else {
			$errorDomaine = "Ce FQDN existe déjà veuillez en choisir un autre !";
		}	
	
	} elseif (isset($_POST['publicAos'])) {
		
		if (isset($fqdnDev)) {
			$backFqdn = explode('.', $fqdnDev, 2);
		}
		$fqdnAos = $backFqdn[1];
		$ex = explode(".", $fqdnAos, 2);
		/*echo $ex[0]."<br/>";
		echo $ex[1]."<br/>";*/
		
		if (isset($_POST["aosBdd"]) && $_POST["aosBdd"] == "add") {
			$devBdd = '1';
			shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' aos.itinet.fr');
		} else {
			$devBdd = '0';
		}
		
		// echo $fqdnAos;
		
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdn = '".$fqdnAos."', publicAvailableAos = 1, publicBddAos = ".$devBdd.", publicEnabledAos = 1  WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		
		shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
		shell_exec('/var/www/aos/script/addPublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$ex[0].' aos.itinet.fr');
		shell_exec('/var/www/aos/script/addenregzone.sh '.$ex[0].' aos.itinet.fr fqdn 88.177.168.133');
		
		header('Location: index.php?p=web');
	} 
	
	//###########################################################################
	//	AOS
	//###########################################################################
	
	if (isset($_POST['pubActiverWebAos'])) {
		$ex = explode(".", $fqdnAos, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/enablePublicWebSite.sh '.$ex[0].' '.$ex[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverWebAos'])) {
		$ex = explode(".", $fqdnAos, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$ex[0].' '.$ex[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubActiverBddAos'])) {
		$ex = explode(".", $fqdnAos, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/addPublicDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' '.$ex[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubDesactiverBddAos'])) {
		$ex = explode(".", $fqdnAos, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET publicBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$ex[0].' '.$ex[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['pubSupWebAos'])) {
		$ex = explode(".", $fqdnAos, 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdn = NULL, publicAvailableAos = 0, publicEnabledAos = 0, publicBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/deletePublicDatabase.sh '.$ex[0].' '.$ex[1].'');
		shell_exec('/var/www/aos/script/disablePublicWebSite.sh '.$ex[0].' '.$ex[1].'');
		shell_exec('/var/www/aos/script/deletePublicWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$ex[0].' '.$ex[1].'');
		shell_exec('/var/www/aos/script/delzone.sh '.$ex[0].' '.$ex[1].' fqdn 88.177.168.133');
		
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverWebAos'])) {
		$ex = explode(".", $fqdnDev, 2);
		$exDev = explode(".", $ex[1], 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/enableDevWebSite.sh '.$exDev[0].' '.$exDev[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverWebAos'])) {
		$ex = explode(".", $fqdnDev, 2);
		$exDev = explode(".", $ex[1], 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devEnabledAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$exDev[0].' '.$exDev[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devActiverBddAos'])) {
		$ex = explode(".", $fqdnDev, 2);
		$exDev = explode(".", $ex[1], 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 1 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/addDevDatabase.sh '.$_SESSION['nomUtilisateur'].' '.$exDev[0].' '.$exDev[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devDesactiverBddAos'])) {
		$ex = explode(".", $fqdnDev, 2);
		$exDev = explode(".", $ex[1], 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$exDev[0].' '.$exDev[1].'');
		header('Location: index.php?p=web');
	}
	
	if (isset($_POST['devSupWebAos'])) {
		$ex = explode(".", $fqdnDev, 2);
		$exDev = explode(".", $ex[1], 2);
		$req = $bdd->prepare("UPDATE utilisateurs SET fqdnDev = NULL, devAvailableAos = 0, devEnabledAos = 0, devBddAos = 0 WHERE nomUtilisateur = '".$_SESSION['nomUtilisateur']."'");
		$req->execute();
		shell_exec('/var/www/aos/script/deleteDevDatabase.sh '.$exDev[0].' '.$exDev[1].'');
		shell_exec('/var/www/aos/script/disableDevWebSite.sh '.$exDev[0].' '.$exDev[1].'');
		shell_exec('/var/www/aos/script/deleteDevWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$exDev[0].' '.$exDev[1].'');
		shell_exec('/var/www/aos/script/delzone.sh dev.'.$exDev[0].' '.$exDev[1].' fqdn 88.177.168.133');
		header('Location: index.php?p=web');
	}
	
	//###########################################################################
	//		EXTERNE
	//###########################################################################
	
	if (isset($pubAvailable)) {
		// var_dump($fqdn);
		$nb = count($pubAvailable);
		
		for ($i = 0; $i < $nb; $i++) {
			$expl = explode(".", $fqdn[$i], 2);
			/*echo $expl[0]."<br/>";
			echo $expl[1]."<br/>";*/
			
			// $nomEnregWeb[$i];
			if (isset($_POST['pubactiverweb'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET enabled = 1 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/enableWebSite.sh '.$expl[0].' .'.$expl[1].'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubdesactiverweb'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET enabled = 0 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/disableWebSite.sh '.$expl[0].' .'.$expl[1].'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubactiverbdd'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET bdd = 1 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/addDatabase.sh '.$_SESSION["nomUtilisateur"].' '.$expl[0].' .'.$expl[1].'');
				header('Location: index.php?p=web');
			}
			
			if (isset($_POST['pubdesactiverbdd'.$i.''])) {
				$req = $bdd->prepare("UPDATE servicesWeb SET bdd = 0 WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/deleteDatabase.sh '.$expl[0].' .'.$expl[1].'');
				header('Location: index.php?p=web');
			}
	
	
			if (isset($_POST['pubsupweb'.$i.''])) {
				$req = $bdd->prepare("DELETE FROM servicesWeb WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				
				$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = '".$idEnreg[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/deleteDatabase.sh '.$expl[0].' .'.$expl[1].'');
				shell_exec('/var/www/aos/script/disableWebSite.sh '.$expl[0].' .'.$expl[1].'');
				shell_exec('/var/www/aos/script/deleteWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$expl[0].' .'.$expl[1].'');
				shell_exec('/var/www/aos/script/delzone.sh '.$expl[0].' '.$expl[1].' fqdn 88.177.168.133');
				
				header('Location: index.php?p=web');
			}
		}
	}
	
	if (isset($nomEnregWeb)) {
		// var_dump($nomEnregWeb);
		$nbWeb = count($nomEnregWeb);
		for ($i = 0; $i < $nbWeb; $i++) {
			$exp = explode(".", $nomEnregWeb[$i], 2);
			/*echo $exp[0]."<br/>";
			echo $exp[1]."<br/>";*/
			if (isset($_POST['activerWeb'.$i.''])) {
				$req = $bdd->prepare("UPDATE enregistrements SET web = 1 WHERE idEnreg = '".$idEnregistrementWeb[$i]."'");
				$req->execute();
				
				$req = $bdd->prepare("INSERT INTO servicesWeb(available, enabled, bdd, idEnreg) VALUES(?,?,?,?)");
				$req->execute(array("1", "1", "0", $idEnregistrementWeb[$i]));
				
				shell_exec('/var/www/aos/script/addRepositoryWebSites.sh '.$_SESSION["nomUtilisateur"].'');
				shell_exec('/var/www/aos/script/addWebSite.sh '.$_SESSION["nomUtilisateur"].' '.$exp[0].' .'.$exp[1].'');
				shell_exec('/var/www/aos/script/enableWebSite.sh '.$exp[0].' .'.$exp[1].'');
				
				header('Location: index.php?p=web');
			}
			if (isset($_POST['supWeb'.$i.''])) {
				$req = $bdd->prepare("DELETE FROM enregistrements WHERE idEnreg = '".$idEnregistrementWeb[$i]."'");
				$req->execute();
				shell_exec('/var/www/aos/script/delzone.sh '.$exp[0].' '.$exp[1].' fqdn 88.177.168.133');
				header('Location: index.php?p=web');
			}
		}
	}
?>