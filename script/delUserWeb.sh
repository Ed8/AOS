#!/bin/bash
#Delete user

username=$1
domain=$2
	
#Delete repository in /home/
sudo rm -r /home/$username
sudo echo "User $username deleted !"

#Delete websites
sudo rm -r /var/www/$domain
sudo echo "Repository /www/$domain deleted !"
	
#Delete pub website available conf
sudo rm -r /etc/apache2/sites-available/$domain.conf
sudo echo "File /sites-available/$domain.conf deleted !"
	
#Delete pub website enabled conf
sudo rm -r /etc/apache2/sites-enabled/$domain.conf
sudo echo "File /sites-enabled/$domain.conf deleted !"
	
#Delete dev website available conf
sudo rm -r /etc/apache2/sites-available/dev_$domain.conf
sudo echo "File /sites-available/dev_$domain.conf deleted !"

#Delete dev website enabled conf
sudo rm -r /etc/apache2/sites-enabled/dev_$domain.conf
sudo echo "File /sites-enabled/dev_$domain.conf deleted !"

#Delete user and databases in PhyMyAdmin
sudo mysql -u root -p"sshi94" -e "DROP USER $username@'localhost'; DROP DATABASE IF EXISTS public_$username; DROP DATABASE IF EXISTS dev_$username;"
sudo echo "User $username deleted in PhpMyAdmin !"
sudo echo "Database $username deleted !"
sudo echo "Database dev_$username deleted !"

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

#Check if user exist in group
if grep -q $username /etc/group; then

	#Delete line of group in /etc/group
	sudo sed -i '/'$username'/d' /etc/group
	sudo echo "Group $username deleted !"
else
	sudo echo "User $username doesn't exist in group !"
fi

#Check if user exist in sftp_config
if grep -q -e '<User '$username'>' /etc/ssh/sftp_config ;then
	sudo sed -i '/<User '$username'>/,+5d' /etc/ssh/sftp_config
	sudo echo "SFTP config $username deleted !"
else
	sudo echo "User $username doesn't exist in sftp_config !"
fi
