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
			read usernameadd
			sudo echo "Enter password :"
			read passwordadd
			sudo bash addUser.sh $usernameadd $passwordadd
			sudo bash addUserPhpMyAdmin.sh $usernameadd $passwordadd
		elif [[ $addanswer == *"2"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read addwebsite
			if [[ $addwebsite == *"1"* ]]; then
				sudo echo "Enter username :"
				read usernameaddpublicwebsite
				sudo echo "Enter FQDN :"
				read fqdnaddpublicwebsite
				sudo bash addRepositoryWebSites.sh $usernameaddpublicwebsite
				sudo bash addPublicWebSite.sh $usernameaddpublicwebsite $fqdnaddpublicwebsite
			elif [[ $addwebsite == *"2"* ]];then
				sudo echo "Enter username :"
				read usernameadddevwebsite
				sudo echo "Enter FQDN :"
				read fqdnadddevwebsite
				sudo bash addRepositoryWebSites.sh $usernameadddevwebsite
				sudo bash addDevWebSite.sh $usernameadddevwebsite $fqdnadddevwebsite
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"3"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read enablewebsite
			if [[ $enablewebsite == *"1"* ]]; then
				sudo echo "Enter FQDN :"
				read fqdnenablepublicwebsite
				sudo bash enablePublicWebSite.sh $fqdnenablepublicwebsite
			elif [[ $enablewebsite == *"2"* ]];then
				sudo echo "Enter FQDN :"
				read fqdnenabledevwebsite
				sudo bash enableDevWebSite.sh $fqdnenabledevwebsite
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"4"* ]]; then
			sudo echo "1 - public database"
			sudo echo "2 - dev database"
			read adddb
			if [[ $adddb == *"1"* ]]; then
				sudo echo "Enter username :"
				read usernameaddpublicdatabase
				sudo bash addPublicDatabase.sh $usernameaddpublicdatabase
			elif [[ $adddb == *"2"* ]]; then
				sudo echo "Enter username :"
				read usernameadddevdatabase
				sudo bash addDevDatabase.sh $usernameadddevdatabase
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $addanswer == *"5"* ]]; then
			sudo echo "Enter username :"
			read usernamechangepassword
			sudo echo "Enter new password :"
			read passwordchange
			sudo bash changePassword.sh $usernamechangepassword $passwordchange
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
			read usernamedel
			sudo echo "Enter user's FQDN :"
			read fqdndel
			sudo bash deleteUser.sh $usernamedel $fqdndel
		
		elif [[ $delanswer == *"2"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read disablewebsite
			if [[ $disablewebsite == *"1"* ]]; then
				sudo echo "Enter FQDN :"
				read fqdndisablepublicwebsite
				sudo bash disablePublicWebSite.sh $fqdndisablepublicwebsite
			elif [[ $disablewebsite == *"2"* ]];then
				sudo echo "Enter FQDN :"
				read fqdndisabledevwebsite
				sudo bash disableDevWebSite.sh $fqdndisabledevwebsite
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $delanswer == *"3"* ]]; then
			sudo echo "1 - public website"
			sudo echo "2 - dev website"
			read delwebsite
			if [[ $delwebsite == *"1"* ]]; then
				sudo echo "Enter Username :"
				read usernamedelpublicdatabase
				sudo echo "Enter FQDN :"
				read fqdndelpublicwebsite
				sudo bash disablePublicWebSite.sh $fqdndelpublicwebsite
				sudo bash deletePublicWebSite.sh $usernamedelpublicdatabase $fqdndelpublicwebsite
				sudo bash deletePublicDatabase.sh $usernamedelpublicdatabase
			elif [[ $delwebsite == *"2"* ]];then
				sudo echo "Enter Username :"
				read usernamedeldevdatabase
				sudo echo "Enter FQDN :"
				read fqdndeldevwebsite
				sudo bash disableDevWebSite.sh $fqdndeldevwebsite
				sudo bash deleteDevWebSite.sh $usernamedeldevdatabase $fqdndeldevwebsite
				sudo bash deleteDevDatabase.sh $usernamedeldevdatabase
			else
				sudo echo "Please enter a right choice !"
			fi
		elif [[ $delanswer == *"4"* ]]; then
			sudo echo "1 - public database"
			sudo echo "2 - dev database"
			read deldb
			if [[ $deldb == *"1"* ]]; then
				sudo echo "Enter username :"
				read usernamedelpublicdatabase
				sudo bash deletePublicDatabase.sh $usernamedelpublicdatabase
			elif [[ $deldb == *"2"* ]]; then
				sudo echo "Enter username :"
				read usernamedeldevdatabase
				sudo bash deleteDevDatabase.sh $usernamedeldevdatabase
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
