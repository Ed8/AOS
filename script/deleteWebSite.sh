#!/bin/bash
#Delete website
username=$1
fqdn=$2
domain=$3


if [ $fqdn == "0" ]; then
        url=$domain
else
        url=$fqdn$domain
fi


if [ -e /etc/apache2/sites-available/$url.conf ]; then
        sudo rm /etc/apache2/sites-available/$url.conf
        sudo echo "File /sites-available/$url.conf deleted !"
else
        sudo echo "File /sites-available/$url.conf doesn't exist !"
fi

if [ -d /var/www/$username/$url ]; then
        sudo rm -r /var/www/$username/$url
        sudo echo "Repository /www/$username/$url deleted !"
else
        sudo echo "Repository /www/$username/$url doesn't exit !"
fi
sudo service apache2 reload
