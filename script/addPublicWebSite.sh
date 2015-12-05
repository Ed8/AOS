#!/bin/bash
#Add public website
username=$1
domain=$2

#Public______________________________________________________________________
#Create repository public_html
if [ -d /var/www/$username/public_html ]; then
	sudo echo "Repository /$username/public_html already exist !"
else
	sudo mkdir /var/www/$username/public_html
	sudo chown $username /var/www/$username/public_html
	sudo echo "Repository /var/www/$username/public_html created !"
fi

#Creating public web page for public_html
if [ -e /var/www/$username/public_html/index.php ]; then
	sudo echo "File /$username/public_html/index.php already exist !"
else
	sudo touch /var/www/$username/public_html/index.php
	sudo echo "Bienvenue sur $username.$domain !" >> /var/www/$username/public_html/index.php
	sudo chown $username /var/www/$username/public_html/index.php
	sudo echo "File /public_html/index.php created !"
fi

#Create public $domain.conf
if [ -e /etc/apache2/sites-available/$username.$domain.conf ]; then
	sudo echo "File $username.$domain.conf already exist !"
else
	sudo touch /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "	ServerName $username.$domain" >> /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "	Documentroot /var/www/$username/public_html" >> /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "</VirtualHost>" >> /etc/apache2/sites-available/$username.$domain.conf
	sudo echo "File /sites-available/$username.$domain.conf created !"
fi
sudo chown -R $username:www-data /var/www/$username
sudo chmod -R 770 /var/www/$username
sudo bash updatezone.sh
sudo service apache2 reload
