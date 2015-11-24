#!/bin/sh
#il y a un probleme avec les '/@$2/d', ca n'evalue pas $2
#Entrer $2 en entier:nomclient@domain.fr
#$1={domain,mail, web}, $2=nomclient, $3={i pour interne(domaine aos), e pour externe}
case $1 in
domain)
if [ -e "/etc/tinydns/root/$2.zone" ]; then
 echo "Le domaine existe deja!"
elif [ "$3"=i ]; then 
 touch /etc/tinydns/root/$2.zone
 echo ".$2.aos.itinet.fr:88.177.168.133:259200 " >> /etc/tinydns/root/$2.zone
elif [ "$3"=e ]; then
 touch /etc/tinydns/root/$2.zone
 echo ".$2:88.177.168.133:259200 " >> /etc/tinydns/root/$2.zone	

fi
sed -n "/$2/p" /etc/tinydns/root/data >> /etc/tinydns/root/$2.zone
sed -i "/.$2.aos.itinet/d" /etc/tinydns/root/data
;;
mail)
if [ -e "/etc/tinydns/root/$2.zone" ]; then
   echo "@$2:88.177.168.133:mx " >> /etc/tinydns/root/$2.zone
elif grep -q "@$2.fr" "/etc/tinydns/root/data"; then
   echo "Le mail existe deja!"
else
   echo "@$2.aos.itinet.fr:88.177.168.133:mx " >> /etc/tinydns/root/data
fi
verification= `grep $domaine main.cf`
if [ -z "$verification" ]; then
sed -i'10 s/$/'\$2'/g' /etc/postfix/main.cf
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
