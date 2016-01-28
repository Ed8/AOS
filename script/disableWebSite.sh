#!/bin/bash
#Disable website
fqdn=$1
domain=$2

if [ $fqdn == "0" ]; then
        url=$domain
else
        url=$fqdn$domain
fi

#Disable pubic website enabled conf
if [ -e /etc/apache2/sites-enabled/$url.conf ]; then
        sudo rm /etc/apache2/sites-enabled/$url.conf
        sudo echo "File /sites-enabled/$url.conf deleted !"
else
        sudo echo "File /sites-enabled/$url.conf doesn't exist !"
fi
sudo service apache2 reload
