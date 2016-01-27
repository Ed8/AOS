#!/bin/bash
#Delete dev website
username=$1
fqdn=$2
domain=$3

#############################################################################
#Delete dev website available conf
if [ -e /etc/apache2/sites-available/dev_$fqdn.$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/dev_$fqdn.$domain.conf
	sudo echo "File /sites-available/dev_$fqdn.$domain.conf deleted !"
else
	sudo echo "File /sites-available/dev_$fqdn.$domain.conf doesn't exist !"
fi
	
if [ -d /var/www/$username/$fqdn.${domain}_dev_html ]; then
	sudo rm -r /var/www/$username/$fqdn.${domain}_dev_html
	sudo echo "Repository /www/$username/$fqdn.$domain_dev_html deleted !"
else
	sudo echo "Repository /www/$username/$fqdn.$domain_dev_html doesn't exit !"
fi
#############################################################################
sudo service apache2 reload
