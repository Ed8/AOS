#!/bin/bash
#Add public website
username=$1
fqdn=$2
domain=$3

#Public______________________________________________________________________
#Create repository public_html
if [ -d /var/www/$username/$fqdn.$domain_public_html ]; then
	sudo echo "Repository /$username/$fqdn.$domain_public_html already exist !"
else
	sudo mkdir /var/www/$username/$fqdn.$domain_public_html
	sudo chown $username /var/www/$username/$fqdn.$domain_public_html
	sudo echo "Repository /var/www/$username/$fqdn.$domain_public_html created !"
fi

#Creating public web page for public_html
if [ -e /var/www/$username/$fqdn.$domain_public_html/index.php ]; then
	sudo echo "File /$username/$fqdn.$domain_public_html/index.php already exist !"
else
	sudo touch /var/www/$username/$fqdn.$domain_public_html/index.php
	sudo echo "Bienvenue sur $fqdn.$domain !" | sudo tee /var/www/$username/$fqdn.domain_public_html/index.php
	sudo chown $username /var/www/$username/$fqdn.$domain_public_html/index.php
	sudo echo "File /$fqdn.$domain_public_html/index.php created !"
fi

#Create public $domain.conf
if [ -e /etc/apache2/sites-available/$fqdn.$domain.conf ]; then
	sudo echo "File $fqdn.$domain.conf already exist !"
else
	sudo touch /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "<VirtualHost *:80>" | sudo tee /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "	ServerName $fqdn.$domain" | sudo tee -a /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "	Documentroot /var/www/$username/$fqdn.$domain_public_html" | sudo tee -a /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "</VirtualHost>" | sudo tee -a /etc/apache2/sites-available/$fqdn.$domain.conf
	sudo echo "File /sites-available/$fqdn.$domain.conf created !"
fi
sudo chown -R $username:www-data /var/www/$username
sudo chmod -R 770 /var/www/$username
sudo service apache2 reload
