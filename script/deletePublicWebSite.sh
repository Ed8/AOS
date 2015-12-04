#!/bin/bash
#Delete public website
username=$1
domain=$2

#############################################################################
#Delete pub website available conf
if [ -e /etc/apache2/sites-available/$username.$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "File /sites-available/$username.$domain.conf deleted !"
else
	sudo echo "File /sites-available/$username.$domain.conf doesn't exist !"
fi

if [ -d /var/www/$username/public_html ]; then
	sudo rm -r /var/www/$username/public_html
	sudo echo "Repository /www/$username/public_html deleted !"
else
	sudo echo "Repository /www/$username/public_html doesn't exit !"
fi
#############################################################################
sudo bash updatezone.sh
sudo service apache2 reload
