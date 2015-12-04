#!/bin/bash
nomuser=$1 
domaine=$2 
adresse=$3 

if  [ "$domaine" != "aos.itinet.fr" ]; then     
	if [ -e "/etc/tinydns/root/$nomuser.zone" ]; then
      		sudo echo "Le domaine existe deja!" 
    	else 
       		sudo touch /etc/tinydns/root/$nomuser.zone
       		sudo echo ".$domaine:$adresse:NS:259200 " >> /etc/tinydns/root/$nomuser.zone
    	fi
fi
sudo bash updatezone.sh













