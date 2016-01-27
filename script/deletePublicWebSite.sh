#!/bin/bash
#Delete public website
username=$1
fqdn=$2
domain=$3

#############################################################################
#Delete pub website available conf
if [ -e /etc/apache2/sites-available/$fqdn.$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "File /sites-available/$fqdn.$domain.conf deleted !"
else
	sudo echo "File /sites-available/$fqdn.$domain.conf doesn't exist !"
fi

if [ -d /var/www/$username/$fqdn.${domain}_public_html ]; then
	sudo rm -r /var/www/$username/$fqdn.${domain}_public_html
	sudo echo "Repository /www/$username/$fqdn.$domain_public_html deleted !"
else
	sudo echo "Repository /www/$username/$fqdn.$domain_public_html doesn't exit !"
fi
#############################################################################
sudo service apache2 reload
