#!/bin/bash
#Add dev website
username=$1
domain=$2

#Dev_________________________________________________________________________
#Create repository dev_html
if [ -d /var/www/$username/dev_html ]; then
	echo "Repository /$username/dev_html already exist !"
else
	sudo mkdir /var/www/$username/dev_html
	sudo chown $username /var/www/$username/dev_html
	sudo echo "Repository /var/www/$username/dev_html created !"
fi

#Creating dev web page for dev_html
if [ -e /var/www/$username/dev_html/index.php ]; then
	echo "File /$username/dev_html/index.php already exist !"
else
	sudo touch /var/www/$username/dev_html/index.php
	sudo echo "Bienvenue sur $username.$domain !" >> /var/www/$username/dev_html/index.php
	sudo chown $username /var/www/$username/dev_html/index.php
	sudo echo "File /dev_html/index.php created !"
fi

#Create dev_$domain.conf
if [ -e /etc/apache2/sites-available/dev_$username.$domain.conf ]; then
	sudo echo "File dev_$username.$domain.conf already exist !"
else
	sudo touch /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "	ServerName dev.$username.$domain" >> /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "	Documentroot /var/www/$username/dev_html" >> /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "</VirtualHost>" >> /etc/apache2/sites-available/dev_$username.$domain.conf
	sudo echo "File /sites-available/dev_$username.$domain.conf created !"
fi
sudo chown -R $username:www-data /var/www/$username
sudo chmod -R 770 /var/www/$username
sudo bash updatezone.sh
sudo service apache2 reload
