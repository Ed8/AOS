#!/bin/bash
#Enable public website
fqdn=$1
domain=$2

if [ $fqdn == "0" ]; then
        url=$domain
else
        url=$fqdn$domain
fi

#Create symbolic link for in sites-available/enabled
if [ -e /etc/apache2/sites-available/$url.conf ]; then
        sudo ln -s /etc/apache2/sites-available/$url.conf /etc/apache2/sites-enabled/$url.conf
        sudo echo "Symbolic link /sites-enabled/$url.conf created !"
else
        sudo echo "File $url.conf doesn't exist !"
fi

sudo service apache2 reload

