#!/bin/bash
#Disable dev website
domain=$1

#############################################################################
#Disable dev website conf
if [ -e /etc/apache2/sites-enabled/dev_$domain.conf ]; then
	sudo rm /etc/apache2/sites-enabled/dev_$domain.conf
	sudo echo "File /sites-enabled/dev_$domain.conf deleted !"
else
	sudo echo "File /sites-enabled/dev_$domain.conf doesn't exist !"
fi
#############################################################################
sudo service apache2 reload
