#!/bin/bash

domain=$1

if [ ! -f "/var/www/rainloop/data/_data_/_default_/domains/$domain.ini" ];then
	sudo touch /var/www/rainloop/data/_data_/_default_/domains/$domain.ini
	sudo echo 'imap_host = "localhost"
imap_port = 143
imap_secure = "None"
imap_short_login = Off
sieve_use = Off
sieve_allow_raw = Off
sieve_host = ""
sieve_port = 4190
sieve_secure = "None"
smtp_host = "10.8.96.3"
smtp_port = 25
smtp_secure = "None"
smtp_short_login = Off
smtp_auth = Off
smtp_php_mail = Off
white_list = ""' >> /var/www/rainloop/data/_data_/_default_/domains/$domain.ini
sudo chown www-data:www-data /var/www/rainloop/data/_data_/_default_/domains/$domain.ini
sudo chmod 770 /var/www/rainloop/data/_data_/_default_/domains/$domain.ini
fi

