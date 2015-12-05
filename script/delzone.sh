#!/bin/bash
nomuser=$1
domaine=$2
enrg=$3
adresse=$4
if [ $enrg = "domaine" -a $domaine != "aos.itinet.fr" ]; then
	if [ -e /etc/tinydns/root/$domaine.zone ]; then
		sudo rm /etc/tinydns/root/$domaine.zone
		sudo sed -i '10 s/'\ $domaine'//g' /etc/postfix/main.cf
		sudo rm -r /var/mail/$domaine
		sudo rm /var/www/rainloop/data/_data_/_default_/domains/$domaine.ini
	else
		sudo echo "Ce domaine n'existe pas!"
	fi
elif [ $enrg = "mx" -a "$domaine" != "aos.itinet.fr" ]; then
	if [ $adresse = "88.177.168.133" ]; then
		if sudo grep -q @$domaine:$adresse /etc/tinydns/root/$domaine.zone; then
			sudo sed -i /"@$domaine:$adresse"/d /etc/tinydns/root/$domaine.zone
			sudo sed -i '10 s/'\ $domaine'//g' /etc/postfix/main.cf
			sudo rm -r /var/mail/$domaine
			sudo rm /var/www/rainloop/data/_data_/_default_/domains/$domaine.ini
		else
			sudo echo "Ce mx est inconnu!"
		fi
	else
		if sudo grep -q @$domaine:$adresse /etc/tinydns/root/$domaine.zone; then
			sudo sed -i /"@$domaine:$adresse"/d /etc/tinydns/root/$domaine.zone
		else 
			sudo echo "Ce mx est inconnu!"
		fi
	fi	
elif [ $enrg = "fqdn" -a $domaine = "aos.itinet.fr" ]; then
	if sudo grep -q =$nomuser.$domaine /etc/tinydns/root/aos.itinet.fr.zone; then
		sudo sed -i /"=$nomuser.$domaine"/d /etc/tinydns/root/aos.itinet.fr.zone
	else
		sudo echo "Ce fqdn est inconnu"
	fi
elif [ $enrg = "fqdn" -a $domaine != "aos.itinet.fr" ]; then	
	if sudo grep -q =$nomuser.$domaine /etc/tinydns/root/$domaine.zone; then
		sudo sed -i /"=$nomuser.$domaine"/d /etc/tinydns/root/$domaine.zone
	else
		sudo echo "Ce fqdn est inconnu"
	fi
fi

sudo bash updatezone.sh
