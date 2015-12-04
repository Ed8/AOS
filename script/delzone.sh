#!/bin/bash
nomuser=$1
domaine=$2
enrg=$3
adresse=$4
if [ $enrg = "domaine" -a $domaine != "aos.itinet.fr" ]; then
	if [ -e /etc/tinydns/root/$nomuser.zone ]; then
		sudo rm /etc/tinydns/root/$nomuser.zone
		sudo sed -i '10 s/'\ $domaine'//g' /etc/postfix/main.cf
		sudo rm -r /var/mail/$domaine
		sudo rm /var/www/rainloop/data/_data_/_default_/domains/$domaine.ini
	else
		sudo echo "Ce domaine n'existe pas!"
	fi
elif [ $enrg = "mail" -a "$domaine" != "aos.itinet.fr" ]; then
	if [ $adresse = "88.177.168.133" ]; then
		if sudo grep -q  @$nomuser.$domaine:$adresse /etc/tinydns/root/$nomuser.zone; then
			sudo sed -i /"@$nomuser.$domaine:$adresse"/d /etc/tinydns/root/$nomuser.zone
			sudo sed -i '10 s/'\ $domaine'//g' /etc/postfix/main.cf
			sudo rm -r /var/mail/$domaine
			sudo rm /var/www/rainloop/data/_data_/_default_/domains/$domaine.ini
		else
			sudo echo "Ce mail est inconnu!"
		fi
	else
		if sudo grep -q  @$nomuser.$domaine:$adresse /etc/tinydns/root/$nomuser.zone; then
			sudo sed -i /"@$nomuser.$domaine:$adresse"/d /etc/tinydns/root/$nomuser.zone
		else 
			sudo echo "Ce mail est inconnu!"
		fi
	fi	
elif [ $enrg = "web" -a $domaine = "aos.itinet.fr" ]; then
	if sudo grep -q +www.$nomuser.$domaine /etc/tinydns/root/aos.zone; then
		sudo sed -i /"+www.$nomuser.$domaine"/d /etc/tinydns/root/aos.zone
		
	else
		sudo echo "Ce web est inconnu"
	fi
elif [ $enrg = "web" -a $domaine != "aos.itinet.fr" ]; then	
	if sudo grep -q +www.$nomuser.$domaine /etc/tinydns/root/$nomuser.zone; then
		sudo sed -i /"+www.$nomuser.$domaine"/d /etc/tinydns/root/$nomuser.zone
		sudo sed -i /"+www.$nomuser.$domaine"/d /etc/tinydns/root/aos.zone
		
	else
		sudo echo "Ce web est inconnu"
	fi
fi
sudo cat /etc/tinydns/root/*.zone > /etc/tinydns/root/data
sudo rm /etc/tinydns/root/data.cdb
sudo make /etc/tinydns/root/data
ssh -i /home/dimitri/.ssh/id_rsa root@dedibox.itinet.fr

