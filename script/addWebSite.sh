#!/bin/bash
#Add website
username=$1
fqdn=$2
domain=$3


if [ $fqdn == "0" ]; then
        url=$domain
else
        url=$fqdn$domain
fi


#Create repository html
if [ -d /var/www/$username/$url ]; then
        sudo echo "Repository /$username/$url already exist !"
else
        sudo mkdir /var/www/$username/$url
        sudo chown $username /var/www/$username/$url
        sudo echo "Repository /var/www/$username/$url created !"
fi

#Creating public web page for html
if [ -e /var/www/$username/$url/index.php ]; then
        sudo echo "File /$username/$url/index.php already exist !"
else
        sudo touch /var/www/$username/$url/index.php
        sudo echo "Bienvenue sur $url !" | sudo tee /var/www/$username/$url/index.php
        sudo chown $username /var/www/$username/$url/index.php
        sudo echo "File /$url/index.php created !"
fi

#Create public $domain.conf
if [ -e /etc/apache2/sites-available/$url.conf ]; then
        sudo echo "File $url.conf already exist !"
else
        sudo touch /etc/apache2/sites-available/$url.conf
        sudo echo "<VirtualHost *:80>" | sudo tee /etc/apache2/sites-available/$url.conf
        sudo echo "     ServerName $url" | sudo tee -a /etc/apache2/sites-available/$url.conf
        sudo echo "     Documentroot /var/www/$username/$url" | sudo tee -a /etc/apache2/sites-available/$url.conf
        sudo echo "</VirtualHost>" | sudo tee -a /etc/apache2/sites-available/$url.conf
        sudo echo "File /sites-available/$url.conf created !"
fi
sudo chown -R $username:www-data /var/www/$username
sudo chmod -R 770 /var/www/$username
sudo service apache2 reload

