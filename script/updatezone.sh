#!/bin/bash
sudo cat /etc/tinydns/root/*.zone > /etc/tinydns/root/data
cd /etc/tinydns/root/
sudo rm /etc/tinydns/root/data.cdb
sudo make 
sudo ssh -i /home/dimitri/.ssh/id_rsa root@dedibox.itinet.fr
