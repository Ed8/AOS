#!/bin/bash
#Enable dev website
domain=$1

#############################################################################
#Activate dev web conf____________________________________________________
#Create symbolic link for dev in sites-available/enabled
if [ -e /etc/apache2/sites-available/dev_$domain.conf ]; then
	sudo ln -s /etc/apache2/sites-available/dev_$domain.conf /etc/apache2/sites-enabled/dev_$domain.conf
	sudo echo "Symbolic link /sites-enabled/dev_$domain.conf created !"
else
	sudo echo "File dev_$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
