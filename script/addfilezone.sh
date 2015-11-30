#!/bin/bash
nomuser=$1 
domaine=$2 #aos.itinet.fr ou domaine.com
adresse=$3 #88.177.168.133 ou adresses externe
if  [ "$domaine" != "aos.itinet.fr" ]; then     
	if [ -e "/etc/tinydns/root/$nomuser.zone" ]; then
      		sudo echo "Le domaine existe deja!" 
    	else 
       		sudo touch /etc/tinydns/root/$nomuser.zone
       		sudo echo ".$domaine:$adresse:259200 " >> /etc/tinydns/root/$nomuser.zone
    	fi
fi
#sudo ssh -i /home/dimitri/.ssh/id_rsa root@dedibox.itinet.fr
#sudo rm /etc/tinydns/root/data.cdb
#sudo make /etc/tinydns/root/data











