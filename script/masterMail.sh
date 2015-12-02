#!/bin/bash

#Script master mail

sudo echo "1 - Créer une boite mail (Tapez 1)"
sudo echo "2 - Supprimer une boîte mail (Tapez 2)"
read reponse

	if [ $reponse = "1" ]; then
		sudo echo "Choissisez un nom :"
		read nom
		sudo echo "Choissisez un domaine :"
		read domaine
		sudo echo "Choissisez un mot de passe :"
		read mdp
		sudo echo "Patientez..."
		sudo bash createUserMail.sh $nom $domaine $mdp
		sudo echo "Votre boîte mail à bien été créez !"
	elif [ $reponse = "2" ]; then
		sudo echo "Définisez le nom de votre boîte mail :"
		read nom
		sudo echo "Définisez le domaine de votre boîte mail :"
		read domaine
		sudo echo "Patientez..."
		sudo bash deleteUserMail.sh $nom $domaine
		sudo echo "Votre boîte mail à bien été supprimez !"
	else
		sudo echo "Entrez 1 (Création) ou 2 (Suppression) d'une boîte mail !"
	fi
