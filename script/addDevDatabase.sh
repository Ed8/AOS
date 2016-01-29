#!/bin/bash
#Create dev database
username=$1
fqdn=$2
domain=$3

url=$fqdn"_"$domain

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS dev_$url; GRANT ALL PRIVILEGES ON dev_$url.* TO '$username'@'localhost';"
