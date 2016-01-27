#!/bin/bash
#Delete website
username=$1
fqdn=$2
domain=$3

#Delete pub website available conf
if [ -e /etc/apache2/sites-available/$fqdn$domain.conf ]; then
        sudo rm /etc/apache2/sites-available/$fqdn$domain.conf
        sudo echo "File /sites-available/$fqdn$domain.conf deleted !"
else
        sudo echo "File /sites-available/$fqdn$domain.conf doesn't exist !"
fi

if [ -d /var/www/$username/$fqdn$domain ]; then
        sudo rm -r /var/www/$username/$fqdn$domain
        sudo echo "Repository /www/$username/$fqdn$domain deleted !"
else
        sudo echo "Repository /www/$username/$fqdn$domain doesn't exit !"
fi
#############################################################################
sudo service apache2 reload

