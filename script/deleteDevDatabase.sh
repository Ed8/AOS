#!/bin/bash
#Delete public database
fqdn=$1
domain=$2

url=$fqdn$domain

sudo mysql -u root -p"sshi94" -e "DROP DATABASE IF EXISTS dev_\`$url\`;"
