#!/bin/bash
#Enable dev website
username=$1
domain=$2

#############################################################################
#Activate dev web conf____________________________________________________
#Create symbolic link for dev in sites-available/enabled
if [ -e /etc/apache2/sites-available/dev_$username.$domain.conf ]; then
	sudo ln -s /etc/apache2/sites-available/dev_$username.$domain.conf /etc/apache2/sites-enabled/dev_$username.$domain.conf
	sudo echo "Symbolic link /sites-enabled/dev_$username.$domain.conf created !"
else
	sudo echo "File dev_$username.$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
