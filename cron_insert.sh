#!/bin/sh
echo "
cd `ls ${0} | sed -e "s/$(basename ${0})//"`
for times in 1 2 3
do
  /usr/bin/php ./instagram_insert.php 
  #/usr/bin/php ./instagram_insert_all.php
  sleep 10
  echo $times `date`
done
"
