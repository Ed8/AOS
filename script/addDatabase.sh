#!/bin/bash
#Create database
username=$1
fqdn=$2
domain=$3

if [ $fqdn == "0" ]; then
	url=$domain
else
	url=$fqdn$domain
fi

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS \`$url\`; GRANT ALL PRIVILEGES ON \`$url\`.* TO '$username'@'localhost';"

