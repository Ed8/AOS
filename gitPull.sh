#!/bin/bash

git pull
sudo chown -R www-data:gitusers /var/www/aos/
sudo chmod -R 570 /var/www/aos/
exit
