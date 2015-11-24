#!/bin/bash
#Master Script Web

sudo echo "Adding or Remove an account for website ?(add or del)"
read answer

	if [[ $answer == *"add"* ]]; then
		sudo echo "Choose a username :"
		read username
		sudo echo "Choose a password :"
		read pass1
		sudo echo "Confirmed your password :"
		read pass2
		sudo echo "Choose your domain name :"
		read domain
		sudo echo "Script processing ..."
		sudo bash /var/www/aos/scripts/addUserWeb.sh $username $pass1 $pass2 $domain
	elif [[ $answer == *"del"* ]]; then
		sudo echo "Choose Username you want to delete :"
		read username
		sudo echo "Choose Domain you want to delete :"
		read domain
		sudo echo "Script processing ..."
		sudo bash /var/www/aos/scripts/delUserWeb.sh $username $domain
	else	
		sudo echo "Wrong answer, enter 'add' or 'del' !"
	fi
