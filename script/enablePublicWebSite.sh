#!/bin/bash
#Enable public website
username=$1
domain=$2

#############################################################################
#Activate public web conf____________________________________________________
#Create symbolic link for public in sites-available/enabled
if [ -e /etc/apache2/sites-available/$username.$domain.conf ]; then
	sudo ln -s /etc/apache2/sites-available/$username.$domain.conf /etc/apache2/sites-enabled/$username.$domain.conf
	sudo echo "Symbolic link /sites-enabled/$username.$domain.conf created !"
else
	sudo echo "File $username.$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
