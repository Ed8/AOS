<?php
    session_start();
    if(!isset($_SESSION['idUtilisateur'])){
        header('Location: index.php');
    }
    require('connexionBdd.php');
    
    //Récupération des information pour le formulaire
    $req = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur INNER JOIN enregistrements ON domaines.idDomaine = enregistrements.idDomaine WHERE utilisateurs.idUtilisateur = ? AND adresseIp = ?");
    $req->execute(array($_SESSION['idUtilisateur'], '88.177.168.133'));
    while($resultat = $req->fetch()){
        $tabDomaine[] = $resultat['domaine'];
    }
    
    //Création d'un compte mail pour un domaine externe
    if(isset($_POST['creerMail'])){
        $adresseMail = htmlspecialchars($_POST['mail']);
        $domaine = htmlspecialchars($_POST['domaine']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $mdpCrypt = sha1($_POST['mdp']);
        $adresseMailC = $adresseMail.'@'.$domaine;
        
        //Vérifie si les champs ont été compléter.
        if(!empty($_POST['mail']) AND !empty($_POST['mdp'])){
            //Requête pour récuperer l'id du domaine entrer.
            $reqIdDomaine = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur WHERE utilisateurs.idUtilisateur = ? AND domaine = ?");
            $reqIdDomaine->execute(array($_SESSION['idUtilisateur'], $domaine));
            $resultatIdDomaine = $reqIdDomaine->fetch();
            //Enregistrement Domaine externe
            $reqVerifMail = $bdd->prepare("SELECT * FROM mail WHERE idDomaine = ? AND adresseMail = ?");
            $reqVerifMail->execute(array($resultatIdDomaine['idDomaine'], $adresseMailC));
            $resultatVerifMail = $reqVerifMail->fetch();
            
            if($resultatVerifMail['adresseMail']){
                $messErreurMail = "Votre adresse mail existe déjà !";
            } else {
                $reqEnregistrementExterne = $bdd->prepare("INSERT INTO mail(adresseMail,mdp,idDomaine) VALUES(?,?,?)");
                $reqEnregistrementExterne->execute(array($adresseMailC, $mdpCrypt, $resultatIdDomaine['idDomaine']));
                //$output = shell_exec('/var/www/aos/script/createUserMail.sh '.$adresseMail.' '.$domaine.' '.$mdp);
                $messConfirmMail = "Votre boîte mail à bien été créer !";
            }
        } else {
            $messErreurMail = "Veuillez remplir tous les champs !";
        }    
    }
    
    //Requête pour aos
    //Récupération de la valeur de actifMail
    $reqAos = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = ?');
    $reqAos->execute(array($_SESSION['idUtilisateur']));
    $resultatAos = $reqAos->fetch();
    
    //Activer boîte mail aos
    if(isset($_POST['activer'])){
        if(!empty($_POST['mdpAos']) AND !empty($_POST['mdpConfAos'])){
            $mdpAos = htmlspecialchars($_POST['mdpAos']);
            $mdpConfAos = htmlspecialchars($_POST['mdpConfAos']);
            $domaine = "aos.itinet.fr";
            if($mdpAos == $mdpConfAos){
                $reqUpdateActif = $bdd->prepare('UPDATE utilisateurs SET actifMail = 1 WHERE idUtilisateur = ?');
                $reqUpdateActif->execute(array($_SESSION['idUtilisateur']));
                //$output = shell_exec('/var/www/aos/script/createUserMail.sh '.$_SESSION['nomUtilisateur'].' '.$domaine.' '.$mdpAos);
                
                $messConfirmMail = 'Votre boîte mail aos à bien été activé !</br>Votre adresse mail est : '.$_SESSION['nomUtilisateur'].'@'.$domaine.' !';
                
                $reqAos = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = ?');
                $reqAos->execute(array($_SESSION['idUtilisateur']));
                $resultatAos = $reqAos->fetch();
            } else {
                $messErreurMail = "Vos deux mot de passe ne correspondent pas !";
            }
        } else {
            $messErreurMail = "Veuillez remplir tous les champs !";
        }
        
    }

    //Desactiver boîte mail aos
    if(isset($_POST['supprimer'])){
        $domaine = "aos.itinet.fr";
        $reqUpdateActif = $bdd->prepare('UPDATE utilisateurs SET actifMail = 0 WHERE idUtilisateur = ?');
        $reqUpdateActif->execute(array($_SESSION['idUtilisateur']));
        //$output = shell_exec('/var/www/aos/script/deleteUserMail.sh '.$_SESSION['nomUtilisateur'].' '.$domaine);
        
        $messConfirmMail = "Votre boîte mail aos à bien été supprimer !";
        
        $reqAos = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = ?');
        $reqAos->execute(array($_SESSION['idUtilisateur']));
        $resultatAos = $reqAos->fetch();
    }

    //Suppression d'un compte mail pour un domaine externe
    if(isset($_POST['supprimerExterne'])){
        $adresseMail=htmlspecialchars($_POST['valeurMail']);
        
        $reqIdDomaine = $bdd->prepare("SELECT * FROM domaines INNER JOIN mail ON domaines.idDomaine = mail.idDomaine WHERE adresseMail = ?");
        $reqIdDomaine->execute(array($adresseMail));
        $resultatIdDomaine = $reqIdDomaine->fetch();
        
        $reqSuppressionMail = $bdd->prepare('DELETE FROM mail WHERE adresseMail = ? AND idDomaine = ?');
        $reqSuppressionMail->execute(array($adresseMail, $resultatIdDomaine['idDomaine']));
        
        //Explode de l'adresse email pour le script shell
        $explodeAdresseMail = explode('@', $adresseMail);
        $nomUtilisateur = $explodeAdresseMail[0];
        $domaine = $explodeAdresseMail[1];
        //$output = shell_exec('/var/www/aos/script/deleteUserMail.sh '.$nomUtilisateur.' '.$domaine);
    }

    //Lister les mails qu'il possède
    $recupMail = $bdd->prepare('SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur INNER JOIN mail ON domaines.idDomaine = mail.idDomaine WHERE utilisateurs.idUtilisateur = ?');
    $recupMail->execute(array($_SESSION['idUtilisateur']));
    while($resultatRecupMail = $recupMail->fetch()){
        $tabMail[] = $resultatRecupMail['adresseMail'];
    }
    
?>