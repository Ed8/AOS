#!/bin/bash
#Create public database
username=$1
fqdn=$2
domain=$3

url=$fqdn$domain

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS public_\`$url\`; GRANT ALL PRIVILEGES ON public_\`$url\`.* TO '$username'@'localhost';"
