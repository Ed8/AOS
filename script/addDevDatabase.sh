#!/bin/bash
#Create dev database
username=$1
fqdn=$2
domain=$3

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS dev_$fqdn.$domain; GRANT ALL PRIVILEGES ON dev_$fqdn.$domain.* TO '$username'@'localhost';"
