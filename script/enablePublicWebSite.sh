#!/bin/bash
#Enable public website
domain=$1

#############################################################################
#Activate public web conf____________________________________________________
#Create symbolic link for public in sites-available/enabled
if [ -e /etc/apache2/sites-available/$domain.conf ]; then
	sudo ln -s /etc/apache2/sites-available/$domain.conf /etc/apache2/sites-enabled/$domain.conf
	sudo echo "Symbolic link /sites-enabled/$domain.conf created !"
else
	sudo echo "File $domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
