#!/bin/sh
#il y a un probleme avec les '/@$2/d', ca n'evalue pas $2
case $1 in
domain)
rm /etc/tinydns/root/$2.zone
;;
mail)
if [ -e "/etc/tinydns/root/$2.zone" ]; then
 sed -i "/@$2.aos.itinet.fr/d" /etc/tinydns/root/$2.zone
else
 sed -i "/@$2.aos.itinet.fr/d" /etc/tinydns/root/data
fi
;;
web) 
if [ -e "/etc/tinydns/root/$2.zone" ]; then
 sed -i "/www.$2.aos.itinet.fr/d" /etc/tinydns/root/$2.zone
else
 sed -i "/www.$2.aos.itinet.fr/d" /etc/tinydns/root/data
fi
;;
esac
