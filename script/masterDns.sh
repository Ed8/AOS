#!/bin/bash

#Master dns

sudo echo "1 - Créer un domaine"
sudo echo "2 - Créer un enregistrement"
sudo echo "3 - Supprimer"
read reponse

if [ $reponse = "1" ]; then
	sudo echo "Entrer votre nom d'utilisateur"
	read nomuser
	sudo echo "Entrer votre domaine"
	read domaine
	sudo echo "Entrer l'adresse ip du domaine"
	read adresse
	sudo echo "Patientez...."
	sudo bash addfilezone.sh $nomuser $domaine $adresse
	sudo echo "Votre domaine a bien été créé"
elif [ $reponse = "2" ]; then
	sudo echo "Entrer votre nom d'utilisateur"
	read nomuser
	sudo echo "Entrer votre domaine"
	read domaine
	sudo echo "Entrer votre enregistrement (mx,fqdn)"
	read enrg
	sudo echo "Entrer l'adresse ip de l'enregistrement"
	read adresse
	sudo bash addenregzone.sh $nomuser $domaine $enrg $adresse
	sudo echo "Votre enregistrement a bien été ajouté à votre domaine"
elif [ $reponse = "3" ]; then
	sudo echo "Entrer votre nom d'utilisateur"
	read nomuser
	sudo echo "Entrer votre domaine"
	read domaine
	sudo echo "Entrer votre enregistrement (domaine,mx,fqdn)"
	read enrg
	sudo echo "Entrer votre adresse ip du domaine ou de l'enregistrement"
	read adresse
	sudo bash delzone.sh $nomuser $domaine $enrg $adresse
	sudo echo "Suppression ok"
else 
	sudo echo "Entrer un choix valide"
fi
