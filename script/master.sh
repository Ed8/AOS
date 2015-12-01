#!/bin/bash

sudo echo "1 - DNS"
sudo echo "2 - WEB"
sudo echo "3 - MAIL"
read reponse

	if [ $reponse = "1" ]; then
		sudo bash masterDns.sh
	elif [ $reponse = "2" ]; then
		sudo bash masterScriptWeb.sh
	elif [ $reponse = "3" ]; then
		sudo bash masterMail.sh
	else
		sudo echo "Veuillez entrer 1, 2 ou 3"
	fi
		
