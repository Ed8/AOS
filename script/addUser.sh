#!/bin/bash
#Create user

username=$1
pass=$2
#############################################################################
#Create username /etc/passwd
if grep -q $username /etc/passwd; then
	sudo echo "User $username already exist in /etc/passwd !"
else
	sudo useradd -p $pass -s /usr/bin/mysecureshell $username -g sftpusers
	sudo echo "User $username added in passwd,shadow and sftpusers group affected !"
	
	#changing to encrypted password
        sudo echo "$username:$pass" | sudo chpasswd
	
	#Set quota Web
	sudo setquota -u $username 204800 256000 204800 256000 /dev/sda5 
	sudo echo "Quota sets for $username to 250Mo !"
fi
