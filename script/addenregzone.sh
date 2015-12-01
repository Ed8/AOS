#!/bin/bash
nomuser=$1
domaine=$2 
enrg=$3
adresse=$4
if [ $enrg = "mail" ]; then
	if [ -e "/etc/tinydns/root/$nomuser.zone" ]; then
		if sudo grep -q @$nomuser.$domaine /etc/tinydns/root/$nomuser.zone; then
            		sudo echo "Ce mail existe deja!"
         	else
			if [ $adresse = "88.177.168.133" ]; then
				sudo echo "@$nomuser.$domaine:$adresse:mx" >> /etc/tinydns/root/$nomuser.zone	
				verification=`sudo grep $domaine /etc/postfix/main.cf`
	   			if [ -z "$verification" ]; then
	   				sudo sed -i '10 s/$/'\ $domaine'/g' /etc/postfix/main.cf
					sudo mkdir /var/mail/$domaine
					sudo chown -R vmail:vmail /var/mail/$domaine 
					sudo bash domainRainloop.sh $domaine
				fi
			else				
				sudo echo "@$nomuser.$domaine:$adresse:mx" >> /etc/tinydns/root/$nomuser.zone				
           		fi
					
	    	fi	   		
	else
	   sudo echo "Veuillez creer un domaine!"
	fi
elif [ $enrg = "web" ]; then
	if [ -e "/etc/tinydns/root/$nomuser.zone" ]; then
		if sudo grep -q +www.$nomuser.$domaine /etc/tinydns/root/$nomuser.zone; then
			sudo echo "Ce web existe deja!"
		else
 	   		sudo echo "+www.$nomuser.$domaine:$adresse:86400 " >> /etc/tinydns/root/$nomuser.zone
			sudo echo "+www.dev.$nomuser.$domaine:$adresse:86400 " >> /etc/tinydns/root/$nomuser.zone
		fi

	elif sudo grep -q "+www.$nomuser" "/etc/tinydns/root/aos.zone"; then
  	   	sudo echo "Le web existe deja!"
	else
  	 	sudo echo "+www.$nomuser.$domaine:88.177.168.133:86400 " >> /etc/tinydns/root/aos.zone
		sudo echo "+www.dev.$nomuser.$domaine:88.177.168.133:86400 " >> /etc/tinydns/root/aos.zone
	fi
fi


