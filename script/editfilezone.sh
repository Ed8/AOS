#!/bin/sh
#$1=(domain, mail, web)  $2=nomàremplacer $3=nouveaunom
chemin=/etc/tinydns/root
case $1 in
domain)
if [ ! -e "/etc/tinydns/root/$2.zone" ]; then
 echo "Le domaine nexiste pas!"
else
 mv chemin/$2.zone chemin/$3.zone
 sed -i "s/.$2/.$3/g" chemin/$3.zone
fi

;;
mail)
if [ -e "/etc/tinydns/root/$2.zone" ]; then
   echo "@$2.aos.itinet.fr:88.177.168.133:86400 " >> /etc/tinydns/root/$2.zone
elif grep -q "@$2.aos.itinet.fr" "/etc/tinydns/root/data"; then
   echo "Le mail existe deja!"
else
   echo "@$2.aos.itinet.fr:88.177.168.133:86400 " >> /etc/tinydns/root/data
fi
;;
web) 
if [ -e "/etc/tinydns/root/$2.zone" ]; then
 echo "+www.$2.aos.itinet.fr:88.177.168.133:86400 " >> /etc/tinydns/root/$2.zone
elif grep -q "www.$2.aos.itinet.fr" "/etc/tinydns/root/data"; then
   echo "Le web existe deja!"
else
   echo "+www.$2.aos.itinet.fr:88.177.168.133:86400 " >> /etc/tinydns/root/data
fi
;;
esac
