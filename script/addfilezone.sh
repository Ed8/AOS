#!/bin/bash
nomuser=$1 
domaine=$2 
adresse=$3 

if  [ "$domaine" != "aos.itinet.fr" ]; then     
	if [ -e "/etc/tinydns/root/$domaine.zone" ]; then
      		sudo echo "Le domaine existe deja!" 
    	else 
       		sudo touch /etc/tinydns/root/$domaine.zone
       		sudo echo ".$domaine:$adresse::259200 " >> /etc/tinydns/root/$domaine.zone
    	fi
fi
sudo bash updatezone.sh
