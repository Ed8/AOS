#!/bin/bash
#Create dev database
username=$1

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS dev_$username; GRANT ALL PRIVILEGES ON dev_$username.* TO '$username'@'localhost';"
