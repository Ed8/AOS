#!/bin/bash

# Définition des variables :
nom=$1
domaine=$2
mdp=$3
verification=`sudo grep $nom@$domaine /etc/postfix/vmailbox`
cheminUtil=$domaine/$nom/

#Création de l'utilisateur dans vmailbox :
#Si $verification est vide tu enregistre l'utilisateur
if [ -z "$verification" ]; then	
	sudo echo $nom@$domaine	$cheminUtil >> /etc/postfix/vmailbox
	sudo postmap /etc/postfix/vmailbox
else
	sudo echo "Cette boîte mail existe déja"
	exit
fi

#Création de son répertoire avec les bons droits :

sudo mkdir /var/mail/$domaine/$nom
sudo mkdir /var/mail/$domaine/$nom/cur
sudo mkdir /var/mail/$domaine/$nom/new
sudo mkdir /var/mail/$domaine/$nom/tmp
sudo chown -R vmail:vmail /var/mail/$domaine/

#Reload de postfix pour que les paramètres soit pris en compte :
sudo service postfix reload 

#Configuration IMAP 

#Inscription dans userdb :
sudo userdb $nom@$domaine set uid=1009 gid=1009 home=/var/mail/$domaine/$nom mail=/var/mail/$domaine/$nom

#Mise en place du mot de passe :
/bin/echo "$mdp" | sudo userdbpw -md5 | sudo userdb $nom@$domaine set systempw

#Compilation du fichier userdb
sudo makeuserdb


