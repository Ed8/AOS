#!/bin/bash
#Create public database
username=$1
fqdn=$2
domain=$3

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS public_$fqdn.$domain; GRANT ALL PRIVILEGES ON public_$fqdn.$domain.* TO '$username'@'localhost';"
