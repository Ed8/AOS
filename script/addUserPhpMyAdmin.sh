#!/bin/bash
#Add user in PhyMyAdmin
username=$1
pass=$2

sudo mysql -u root -p"sshi94" -e "CREATE USER '$username'@'localhost' IDENTIFIED BY '$pass'; GRANT USAGE ON *.* TO '$username'@'localhost' IDENTIFIED BY '$pass' WITH MAX_QUERIES_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;"
