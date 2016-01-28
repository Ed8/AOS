#!/bin/bash
#Enable public website
fqdn=$1
domain=$2

#Activate public web conf____________________________________________________
#Create symbolic link for public in sites-available/enabled
if [ -e /etc/apache2/sites-available/$fqdn.$domain.conf ]; then
	sudo ln -s /etc/apache2/sites-available/$fqdn.$domain.conf /etc/apache2/sites-enabled/$fqdn.$domain.conf
	sudo echo "Symbolic link /sites-enabled/$fqdn.$domain.conf created !"
else
	sudo echo "File $fqdn.$domain.conf doesn't exist !"
fi
sudo service apache2 reload
