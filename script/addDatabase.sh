#!/bin/bash
#Create database
username=$1
fqdn=$2
domain=$3

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS $fqdn$domain; GRANT ALL PRIVILEGES ON $fqdn$domain.* TO '$username'@'localhost';"

