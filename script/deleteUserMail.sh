#!/bin/bash

nom=$1
domaine=$2
verification=`sudo grep $nom@$domaine /etc/postfix/vmailbox`

	if [ -z "$verification" ]; then
		sudo echo "Cette boite mail est inconnu"
		exit
	else
		sudo sed -i "/$nom@$domaine/d" /etc/postfix/vmailbox
		sudo postmap /etc/postfix/vmailbox
		sudo sed -i "/$nom@$domaine/d" /etc/courier/userdb
		sudo makeuserdb 
		sudo rm -R /var/mail/$domaine/$nom/
	fi
sudo service postfix reload
