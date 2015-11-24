#!/bin/bash
# adding user for apache2, SFTP acces, MySecureShell, PhpMyAdmin

username=$1
pass1=$2
pass2=$3
domain=$4

#Check passwords are same
if [ $pass1 = $pass2 ]; then

	#Account on server#
	#Add user into /etc/passwd and change password crypted 
	sudo useradd -p $pass1 -s /usr/bin/mysecureshell $username
	sudo echo "$username:$pass1" | chpasswd $pass1
	sudo echo "User $username added in /etc/passwd/ !"
	
	#Create /home/user repository
	sudo mkdir /home/$username
	sudo echo "Repository /home/$username created !"
	#Creating user repositories for web
	sudo mkdir /var/www/$domain
	sudo echo "Repository /var/www/$domain created !"
	sudo mkdir /var/www/$domain/public_html	
	sudo echo "Repository /var/www/$domain/public_html created !"
	sudo mkdir /var/www/$domain/dev_html
	sudo echo "Repository /var/www/$domain/dev_html created !"

	sudo touch /var/www/$domain/public_html/index.php
	sudo echo "Bienvenue sur $domain !" >> /var/www/$domain/public_html/index.php
	
	sudo touch /var/www/$domain/dev_html/index.php
	sudo echo "Bienvenue sur $domain !" >> /var/www/$domain/dev_html/index.php
	
	#Create symbolinc link var/www/ and /home/
	sudo ln -s /var/www/$domain /home/$username/$domain
	sudo echo "Symbolic link /home/$username/$domain created !"

	#Change repository owner
	sudo chown -R $username /home/$username
	sudo chown -R $username /home/$username/$domain
	sudo chown -R $username /home/$username/$domain/dev_html
	sudo chown -R $username /home/$username/$domain/public_html
	sudo chown -R $username /var/www/$domain
	sudo chmod -R 700 /var/www/$domain
	sudo chmod -R 700 /home/$username
	sudo chmod -R 700 /home/$username/$domain
	sudo chmod -R 700 /home/$username/$domain/dev_html
	sudo chmod -R 700 /home/$username/$domain/public_html
			
	#Create apache2 conf for 2 websites
	sudo touch /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "	ServerName www.dev.$domain" >> /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "	Documentroot /var/www/$username/dev_html" >> /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "</VirtualHost>" >> /etc/apache2/sites-available/dev_$domain.conf
	sudo echo "File /sites-available/dev_$domain.conf created !"

	#Create symbolic link for dev in sites-available/enabled
	sudo ln -s /etc/apache2/sites-available/dev_$domain.conf /etc/apache2/sites-enabled/dev_$domain.conf
	sudo echo "Symbolic link /sites-enabled/dev_$domain.conf created !"

	sudo touch /etc/apache2/sites-available/$domain.conf
	sudo echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$domain.conf
	sudo echo "	ServerName www.$domain" >> /etc/apache2/sites-available/$domain.conf
	sudo echo "	Documentroot /var/www/$username/public_html" >> /etc/apache2/sites-available/$domain.conf
	sudo echo "</VirtualHost>" >> /etc/apache2/sites-available/$domain.conf
	sudo echo "File /sites-available/$domain.conf created !"

	#Create symbolic link for public in sites-available/enabled
	sudo ln -s /etc/apache2/sites-available/$domain.conf /etc/apache2/sites-enabled/$domain.conf
	sudo echo "Symbolic link /sites-enabled/$domain.conf created !"

	#Create config SFTP connection
	sudo echo "<User $username>" >> /etc/ssh/sftp_config
	sudo echo "	Home /home/$username/$domain" >> /etc/ssh/sftp_config
	sudo echo "	StayAtHome true" >> /etc/ssh/sftp_config
	sudo echo "	VirtualChroot true" >> /etc/ssh/sftp_config
	sudo echo "	IgnoreHidden true" >> /etc/ssh/sftp_config
	sudo echo "</User>" >> /etc/ssh/sftp_config
	sudo echo "SFTP configuration for $username created !"

	#Add user in PhpMyAdmin and create 2 databases
	sudo mysql -u root -p"sshi94" -e "CREATE USER '$username'@'localhost' IDENTIFIED BY '$pass1'; GRANT USAGE ON *.* TO '$username'@'localhost' IDENTIFIED BY '$pass1' WITH MAX_QUERIES_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0; CREATE DATABASE IF NOT EXISTS public_$username; GRANT ALL PRIVILEGES ON public_$username.* TO '$username'@'localhost'; CREATE DATABASE IF NOT EXISTS dev_$username; GRANT ALL PRIVILEGES ON dev_$username.* TO '$username'@'localhost';"
	sudo echo "User $username added in PhpMyAdmin !"
	sudo echo "Database $username created !"
	sudo echo "Database dev_$username created !"

else
	sudo echo "Passwords don't match !"
fi
