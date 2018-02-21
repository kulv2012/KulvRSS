#sh
source /home/wuhaiwen/.bash_profile
dir=`pwd`


echo "update begin"
date


/home/wuhaiwen/php/bin/php -dsafe_mode=on /home/wuhaiwen/webroot/KulvRSS/actions/mis/updateAllRss.php 0 2>&1

date
echo "update end"

cd $dir

rm /tmp/sno*
