#!/bin/bash
#Change password
username=$1
pass=$2

sudo echo "$username:$pass" | sudo chpasswd
sudo mysql -u root -p"sshi94" -e "SET PASSWORD FOR $username@localhost = PASSWORD('$pass');"
