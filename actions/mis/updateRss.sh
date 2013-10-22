#sh
source /home/wuhaiwen/.bash_profile
export LD_LIBRARY_PATH=/home/wuhaiwen/lib:$LD_LIBRARY_PATH
dir=`pwd`


echo "update begin"
date


/home/wuhaiwen/php/bin/php -dsafe_mode=on /home/wuhaiwen/webroot/KulvRSS/actions/mis/updateAllRss.php 0 2>&1

date
echo "update end"

cd $dir

rm /tmp/sno*
