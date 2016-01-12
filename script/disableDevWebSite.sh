#!/bin/bash
#Disable dev website
username=$1
domain=$2

#############################################################################
#Disable dev website conf
if [ -e /etc/apache2/sites-enabled/dev_$username.$domain.conf ]; then
	sudo rm /etc/apache2/sites-enabled/dev_$username.$domain.conf
	sudo echo "File /sites-enabled/dev_$username.$domain.conf deleted !"
else
	sudo echo "File /sites-enabled/dev_$username.$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
