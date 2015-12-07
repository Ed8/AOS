#!/bin/bash
nomuser=$1
domaine=$2 
enrg=$3
adresse=$4
if [ $enrg = "mx" ]; then
	if [ -e "/etc/tinydns/root/$domaine.zone" ]; then
		if sudo grep -q @$domaine /etc/tinydns/root/$domaine.zone; then
            		sudo echo "Ce mx existe deja!"
         	else
			if [ $adresse = "88.177.168.133" ]; then
				sudo echo "@$domaine:$adresse::86400" >> /etc/tinydns/root/$domaine.zone	
				verification=`sudo grep $domaine /etc/postfix/main.cf`
	   			if [ -z "$verification" ]; then
	   				sudo sed -i '10 s/$/'\ $domaine'/g' /etc/postfix/main.cf
					sudo mkdir /var/mail/$domaine
					sudo chown -R vmail:vmail /var/mail/$domaine 
					sudo bash domainRainloop.sh $domaine
				fi
			else				
				sudo echo "@$domaine:$adresse::86400" >> /etc/tinydns/root/$domaine.zone				
           		fi
	    	fi	   		
	else
	   sudo echo "Veuillez creer un domaine!"
	fi
elif [ $enrg = "fqdn" ]; then
	if [ $domaine != "aos.itinet.fr" ]; then
		if [ $nomuser == "0" ]; then
			if [ -e "/etc/tinydns/root/$domaine.zone" ]; then
				if sudo grep -q =$domaine /etc/tinydns/root/$domaine.zone; then
                                	sudo echo "Ce fqdn existe deja!"
                        	else
                                	sudo echo "=$domaine:$adresse:86400" >> /etc/tinydns/root/$domaine.zone
                        	fi
                	fi
		else
			if [ -e "/etc/tinydns/root/$domaine.zone" ]; then
				if sudo grep -q =$nomuser.$domaine /etc/tinydns/root/$domaine.zone; then
					sudo echo "Ce fqdn existe deja!"
				else
 	   				sudo echo "=$nomuser.$domaine:$adresse:86400" >> /etc/tinydns/root/$domaine.zone
				fi
			fi
		fi
	else
		if [ $domaine = "aos.itinet.fr" ]; then
			if sudo grep -q "=$nomuser" /etc/tinydns/root/aos.itinet.fr.zone; then
  	   			sudo echo "Ce fqdn existe deja!"
			else
  	 			sudo echo "=$nomuser.$domaine:88.177.168.133:86400" >> /etc/tinydns/root/aos.itinet.fr.zone
			fi
		fi
	fi
fi
sudo bash updatezone.sh
