#!/bin/bash
#Create public database
username=$1

sudo mysql -u root -p"sshi94" -e "CREATE DATABASE IF NOT EXISTS public_$username; GRANT ALL PRIVILEGES ON public_$username.* TO '$username'@'localhost';"
