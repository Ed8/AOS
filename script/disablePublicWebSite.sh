#!/bin/bash
#Disable public website
username=$1
domain=$2

#############################################################################
#Disable pubic website enabled conf
if [ -e /etc/apache2/sites-enabled/$username.$domain.conf ]; then
	sudo rm /etc/apache2/sites-enabled/$username.$domain.conf
	sudo echo "File /sites-enabled/$username.$domain.conf deleted !"
else
	sudo echo "File /sites-enabled/$username.$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
