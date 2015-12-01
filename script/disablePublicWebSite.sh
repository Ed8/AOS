#!/bin/bash
#Disable public website
domain=$1

#############################################################################
#Disable pubic website enabled conf
if [ -e /etc/apache2/sites-enabled/$domain.conf ]; then
	sudo rm /etc/apache2/sites-enabled/$domain.conf
	sudo echo "File /sites-enabled/$domain.conf deleted !"
else
	sudo echo "File /sites-enabled/$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
