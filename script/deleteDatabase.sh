#!/bin/bash
#Delete database
fqdn=$1
domain=$2

if [ $fqdn == "0" ]; then
        url=$domain
else
        url=$fqdn$domain
fi

sudo mysql -u root -p"sshi94" -e "DROP DATABASE IF EXISTS \`$url\`;"
