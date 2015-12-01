#!/bin/bash
#Create user

username=$1
pass=$2
#############################################################################
#Create username /etc/passwd
if grep -q $username /etc/passwd; then
	sudo echo "User $username already exist in /etc/passwd !"
else
	sudo useradd -p $pass -s /usr/bin/mysecureshell $username -g sftpusers -G quotaweb
	sudo echo "User $username added in passwd,shadow and sftpusers group affected !"
	
	#changing to encrypted password
        sudo echo "$username:$pass" | sudo chpasswd
	
	#Changing owner /home/user
	#sudo chown -R $username /home/$username
	#sudo echo "Onwer /home/$username changed to $username !"
	
	#sudo chmod -R 700 /home/$username
	#sudo echo "Permissions acces changed to /home/$username !"
fi
