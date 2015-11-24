#!bin/bash

sudo echo "1 - MAIL"
sudo echo "2 - WEB"
read reponse

	if [ $reponse = "1" ]; then
		sudo bash masterMail.sh
	elif [ $reponse = "2" ]; then
		sudo bash masterScriptWeb.sh
	else
		echo "Veuillez rentrer 1 ou 2 "
	fi
		
