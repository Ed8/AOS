#!/bin/bash
#Add repository for website
username=$1

#############################################################################
if [ -d /var/www/$username ]; then
        sudo echo "Repository /www/$username already exist !"
else
        sudo mkdir /var/www/$username
        sudo chown $username /var/www/$username
        sudo chmod 770 /var/www/$username
        sudo echo "Repository /www/$username created !"
fi
#############################################################################
sudo service apache2 reload
