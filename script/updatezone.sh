#!/bin/bash
sudo cat /etc/tinydns/root/*.zone > /etc/tinydns/root/data
sudo rm /etc/tinydns/root/data.cdb
sudo make /etc/tinydns/root/data
sudo ssh -i /home/dimitri/.ssh/id_rsa root@dedibox.itinet.fr
