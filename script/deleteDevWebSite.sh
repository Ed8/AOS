#!/bin/bash
#Delete dev website
username=$1
domain=$2

#############################################################################
#Delete dev website available conf
if [ -e /etc/apache2/sites-available/dev_$username.$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "File /sites-available/dev_$username.$domain.conf deleted !"
else
	sudo echo "File /sites-available/dev_$username.$domain.conf doesn't exist !"
fi
	
if [ -d /var/www/$username/dev_html ]; then
	sudo rm -r /var/www/$username/dev_html
	sudo echo "Repository /www/$username/dev_html deleted !"
else
	sudo echo "Repository /www/$username/dev_html doesn't exit !"
fi
#############################################################################
sudo bash delzone.sh dev.$username $domain fqdn 88.177.168.133
sudo bash updatezone.sh
sudo service apache2 reload
