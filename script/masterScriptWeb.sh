#!/bin/bash
#Master Script Web

while :
do

	sudo echo "1 - Add or enable website(s) and database(s), changing password"
	sudo echo "2 - Remove or disable website(s) and dabase(s)"
	sudo echo "3 - Exit web script"
	read answer

	if [[ $answer == *"1"* ]]; then
		sudo echo "1 - Add user"
		sudo echo "2 - Add website"
		sudo echo "3 - Enable website"
		sudo echo "4 - Create database"
		sudo echo "5 - Change password"
		read addanswer
		
		if [[ $addanswer == *"1"* ]]; then
			sudo echo "Enter username :"
			read username
			sudo echo "Enter password :"
			read password
			sudo bash addUser.sh $username $password
			sudo bash addUserPhpMyAdmin.sh $username $password
		elif [[ $addanswer == *"2"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read addwebsite
			if [[ $addwebsite == *"1"* ]]; then
				sudo echo "Enter username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash addRepositoryWebSites.sh $username
				sudo bash addPublicWebSite.sh $username $fqdn
				sudo bash addenregzone.sh $username $fqdn web 88.177.168.133 
			elif [[ $addwebsite == *"2"* ]];then
				sudo echo "Enter username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash addRepositoryWebSites.sh $username
				sudo bash addDevWebSite.sh $username $fqdn
				sudo bash addenregzone.sh $username $fqdn web 88.177.168.133
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"3"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read enablewebsite
			if [[ $enablewebsite == *"1"* ]]; then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash enablePublicWebSite.sh $username $fqdn
			elif [[ $enablewebsite == *"2"* ]];then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash enableDevWebSite.sh $username $fqdn
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"4"* ]]; then
			sudo echo "1 - public database"
			sudo echo "2 - dev database"
			read adddb
			if [[ $adddb == *"1"* ]]; then
				sudo echo "Enter username :"
				read username
				sudo bash addPublicDatabase.sh $username
			elif [[ $adddb == *"2"* ]]; then
				sudo echo "Enter username :"
				read username
				sudo bash addDevDatabase.sh $username
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"5"* ]]; then
			sudo echo "Enter username :"
			read username
			sudo echo "Enter new password :"
			read password
			sudo bash changePassword.sh $username $password
		else
			sudo echo "Please enter a right choice !"
		fi	
	elif [[ $answer == *"2"* ]]; then
		sudo echo "1 - Delete user"
		sudo echo "2 - Disable website"
		sudo echo "3 - Delete website"
		sudo echo "4 - Delete database"
		read delanswer
		
		if [[ $delanswer == *"1"* ]]; then
			sudo echo "Enter username :"
			read username
			sudo echo "Enter user's FQDN :"
			read fqdn
			sudo bash deleteUser.sh $username $fqdn
			sudo bash delzone.sh $username $fqdn web 88.177.168.133
			sudo bash delzone.sh dev.$username $fqdn web 88.177.168.133
		
		elif [[ $delanswer == *"2"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read disablewebsite
			if [[ $disablewebsite == *"1"* ]]; then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash disablePublicWebSite.sh $username $fqdn
			elif [[ $disablewebsite == *"2"* ]];then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash disableDevWebSite.sh $username $fqdn
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $delanswer == *"3"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read delwebsite
			if [[ $delwebsite == *"1"* ]]; then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash disablePublicWebSite.sh $username $fqdn
				sudo bash deletePublicWebSite.sh $username $fqdn
				sudo bash deletePublicDatabase.sh $username
				sudo bash delzone.sh $username $fqdn web 88.177.168.133
			elif [[ $delwebsite == *"2"* ]];then
				sudo echo "Enter Username :"
				read username
				sudo echo "Enter FQDN :"
				read fqdn
				sudo bash disableDevWebSite.sh $username $fqdn
				sudo bash deleteDevWebSite.sh $username $fqdn
				sudo bash deleteDevDatabase.sh $username
				sudo bash delzone.sh dev.$username $fqdn web 88.177.168.133
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $delanswer == *"4"* ]]; then
			sudo echo "1 - public database"
			sudo echo "2 - dev database"
			read deldb
			if [[ $deldb == *"1"* ]]; then
				sudo echo "Enter username :"
				read username
				sudo bash deletePublicDatabase.sh $username
			elif [[ $deldb == *"2"* ]]; then
				sudo echo "Enter username :"
				read username
				sudo bash deleteDevDatabase.sh $username
			else
				sudo echo "Please enter a right choice !"
			fi
		else
			echo "Please enter a right choice !"
		fi
	elif [[ $answer == *"3"* ]]; then
		exit
	else	
		sudo echo "Please enter a right choice !"
	fi
done
