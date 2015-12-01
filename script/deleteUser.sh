#!/bin/bash
#Delete user
username=$1
domain=$2

#############################################################################
#Delete repository in /home/
#if [ -d /home/$username ]; then
#	sudo rm -r /home/$username
#	sudo echo "repository /home/$username deleted !"
#else
#	sudo echo "Repository /home/$username doesn't exit !"
#fi
#############################################################################
#############################################################################
#Delete websites
if [ -d /var/www/$username ]; then
	sudo rm -r /var/www/$username
	sudo echo "Repository /www/$username deleted !"
else
	sudo echo "Repository /www/$username doesn't exit !"
fi
#############################################################################
#############################################################################
#Disable pub website enabled conf
if [ -e /etc/apache2/sites-enabled/$domain.conf ]; then
        sudo rm /etc/apache2/sites-enabled/$domain.conf
        sudo echo "File /sites-enabled/$domain.conf deleted !"
else
        sudo echo "File /sites-enabled/$domain.conf doesn't exist !"
fi
#############################################################################
#############################################################################
#Delete pub website available conf
if [ -e /etc/apache2/sites-available/$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/$domain.conf
	sudo echo "File /sites-available/$domain.conf deleted !"
else
	sudo echo "File /sites-available/$domain.conf doesn't exist !"
fi
#############################################################################
#############################################################################
#Disable dev website conf
if [ -e /etc/apache2/sites-enabled/dev_$domain.conf ]; then
        sudo rm /etc/apache2/sites-enabled/dev_$domain.conf
        sudo echo "File /sites-enabled/dev_$domain.conf deleted !"
else
        sudo echo "File /sites-enabled/dev_$domain.conf doesn't exist !"
fi
#############################################################################
#############################################################################
#Delete dev website available conf
if [ -e /etc/apache2/sites-available/dev_$domain.conf ]; then
	sudo rm /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "File /sites-available/dev_$domain.conf deleted !"
else
	sudo echo "File /sites-available/dev_$domain.conf doesn't exist !"
fi
#############################################################################
#############################################################################
#Delete user and databases in PhyMyAdmin
sudo mysql -u root -p"sshi94" -e "DROP USER $username@'localhost'; DROP DATABASE IF EXISTS dev_$username; DROP DATABASE IF EXISTS public_$username; DROP DATABASE IF EXISTS public_$username;"
#############################################################################
#############################################################################
#Check if user exist
if grep -q $username /etc/passwd; then
	#Delete line of username in /etc/passwd
	sudo sed -i '/'$username'/d' /etc/passwd
	sudo echo "User $username deleted in /etc/passwd !"
else
	sudo echo "User $username doesn't exist in passwd !"
fi

if grep -q $username /etc/shadow; then
	#Delete line of username in /etc/shadow
	sudo sed -i '/'$username'/d' /etc/shadow
	sudo echo "User $username deleted in /etc/shadow !"
else
	sudo echo "User $username doesn't exist in shadow !"
fi
sudo gpasswd -d $username quotaweb
#############################################################################
sudo service apache2 reload
