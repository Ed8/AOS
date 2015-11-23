#!bin/bash

#Script master mail

echo "1 - Créer une boite mail (Tapez 1)"
echo "2 - Supprimer une boîte mail (Tapez 2)"
read reponse

	if [ $reponse = "1" ]; then
		echo "Choissisez un nom :"
		read nom
		echo "Choissisez un domaine :"
		read domaine
		echo "Choissisez un mot de passe :"
		read mdp
		echo "Patientez..."
		bash createUserMail.sh $nom $domaine $mdp
		echo "Votre boîte mail à bien été créez !"
	elif [ $reponse = "2" ]; then
		echo "Définisez le nom de votre boîte mail :"
		read nom
		echo "Définisez le domaine de votre boîte mail :"
		read domaine
		echo "Patientez..."
		bash deleteUserMail.sh $nom $domaine
		echo "Votre boîte mail à bien été supprimez !"
	else
		echo "Entrez 1 (Création) ou 2 (Suppression) d'un boîte mail !"
	fi
