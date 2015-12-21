<?php
    session_start();
    require('connexionBdd.php');
    //Récupération des information pour le formulaire
    $req = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur INNER JOIN enregistrements ON domaines.idDomaine = enregistrements.idDomaine WHERE utilisateurs.idUtilisateur = ? AND adresseIp = ?");
    $req->execute(array($_SESSION['idUtilisateur'], '88.177.168.133'));
    while($resultat = $req->fetch()){
        $tabDomaine[] = $resultat['domaine'];
    }
    //Ajout de son domaine s'il n'en possède pas
    if(!$resultat){
        $selectDomaine = $bdd->prepare("SELECT * FROM domaines WHERE domaine = ? AND idUtilisateur = ?");
        $selectDomaine->execute(array("aos.itinet.fr", $_SESSION['idUtilisateur']));
        $resultatSelect = $selectDomaine->fetch();

        if(!$resultatSelect['domaine']){
            $reqAjoutDomaineAos = $bdd->prepare("INSERT INTO domaines(domaine,idUtilisateur) VALUES(?,?)");
            $reqAjoutDomaineAos->execute(array("aos.itinet.fr", $_SESSION['idUtilisateur']));
            
            $selectDomaine = $bdd->prepare("SELECT * FROM domaines WHERE domaine = ? AND idUtilisateur = ?");
            $selectDomaine->execute(array("aos.itinet.fr", $_SESSION['idUtilisateur']));
            $resultatSelect = $selectDomaine->fetch();
            
            $reqAjoutEnregistrementAos = $bdd->prepare("INSERT INTO enregistrements(nomEnreg,typeEnreg,adresseIp,idDomaine) VALUES(?,?,?,?)");
            $reqAjoutEnregistrementAos->execute(array('@aos.itinet.fr', 'mx','88.177.168.133', $resultatSelect['idDomaine'])); 
        }
        
    }
    //Contrôle à l'envoie du formulaire
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
            //Vérifier si il possède déjà une boite mail en aos
            if($domaine == "aos.itinet.fr"){ 
                $reqAos = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur INNER JOIN mail ON domaines.idDomaine = mail.idDomaine WHERE utilisateurs.idUtilisateur = ? AND mail.idDomaine = ? AND domaines.domaine = ?");
                $reqAos->execute(array($_SESSION['idUtilisateur'], $resultatIdDomaine['idDomaine'], $domaine));
                $resultatMailAos = $reqAos->fetch();
                    if($resultatMailAos['domaine'] == "aos.itinet.fr"){
                        $messErreurMail = "Vous possédez déjà une boîte mail dans AOS !";
                    } else {
                        //Requête pour ajouter une boîte mail dans aos
                        $reqEnregistrementAos = $bdd->prepare("INSERT INTO mail(adresseMail,mdp,idDomaine) VALUES(?,?,?)");
                        $reqEnregistrementAos->execute(array($adresseMailC, $mdpCrypt, $resultatIdDomaine['idDomaine']));
                        $output = shell_exec('/var/www/aos/script/createUserMail.sh '.$adresseMail.' '.$domaine.' '.$mdp);
                        $messConfirmMail = "Votre boîte mail à bien été créer !";
                    }
            } else {
                //Enregistrement Domaine externe
                $reqVerifMail = $bdd->prepare("SELECT * FROM mail WHERE idDomaine = ? AND adresseMail = ?");
                $reqVerifMail->execute(array($resultatIdDomaine['idDomaine'], $adresseMailC));
                $resultatVerifMail = $reqVerifMail->fetch();
                
                if($resultatVerifMail['adresseMail']){
                    $messErreurMail = "Votre adresse mail existe déjà !";
                } else {
                    $reqEnregistrementExterne = $bdd->prepare("INSERT INTO mail(adresseMail,mdp,idDomaine) VALUES(?,?,?)");
                    $reqEnregistrementExterne->execute(array($adresseMailC, $mdpCrypt, $resultatIdDomaine['idDomaine']));
                    $output = shell_exec('/var/www/aos/script/createUserMail.sh '.$adresseMail.' '.$domaine.' '.$mdp);
                    $messConfirmMail = "Votre boîte mail à bien été créer !";
                }
            }
        } else {
            $messErreurMail = "Veuillez remplir tous les champs !";
        }    
    }
    
    if(isset($_POST['supprMail'])){
        $adresseMail = htmlspecialchars($_POST['mail']);
        $domaine = htmlspecialchars($_POST['domaine']);
        $mdp = sha1($_POST['mdp']);
        $adresseMailC = $adresseMail.'@'.$domaine;
        //Recupérer l'id du domaine 
        $reqIdDomaine = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN domaines ON utilisateurs.idUtilisateur = domaines.idUtilisateur WHERE utilisateurs.idUtilisateur = ? AND domaine = ?");
        $reqIdDomaine->execute(array($_SESSION['idUtilisateur'], $domaine));
        $resultatIdDomaine = $reqIdDomaine->fetch();
        //Vérification si un mail existe 
        $reqVerifMail = $bdd->prepare("SELECT * FROM mail WHERE idDomaine = ? AND adresseMail = ?");
        $reqVerifMail->execute(array($resultatIdDomaine['idDomaine'], $adresseMailC));
        $resultatVerifMail = $reqVerifMail->fetch();
       
        // Suppression de la boîte mail
        if($resultatVerifMail['adresseMail']){
            if($resultatVerifMail['mdp'] == $mdp){
                $reqSupprMail = $bdd->prepare("DELETE FROM mail WHERE adresseMail = ? AND idDomaine = ?");
                $reqSupprMail->execute(array($adresseMailC, $resultatIdDomaine['idDomaine']));
                $output = shell_exec('/var/www/aos/script/deleteUserMail.sh '.$adresseMail.' '.$domaine);
                $messConfirmMail = "Votre boîte mail à été supprimer !";
            } else {
            $messErreurMail = "Votre mot de passe n'est pas correct !";
            }
        } else {
            $messErreurMail = "Votre adresse mail est inconnu !";
        }
    }
?>