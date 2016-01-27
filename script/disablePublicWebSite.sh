#!/bin/bash
#Disable public website
fqdn=$1
domain=$2

#############################################################################
#Disable pubic website enabled conf
if [ -e /etc/apache2/sites-enabled/$fqdn.$domain.conf ]; then
	sudo rm /etc/apache2/sites-enabled/$fqdn.$domain.conf
	sudo echo "File /sites-enabled/$fqdn.$domain.conf deleted !"
else
	sudo echo "File /sites-enabled/$fqdn.$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
