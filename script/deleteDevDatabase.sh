#!/bin/bash
#Delete public database
username=$1

#############################################################################
#Remove database
sudo mysql -u root -p"sshi94" -e "DROP DATABASE IF EXISTS dev_$username;"
#############################################################################
