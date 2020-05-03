#!/bin/bash
echo "You are about to install an experimental version of mcPanel. You have ten seconds to cancel (CTRL+C)."
echo "Please note that this installer is meant for Debian 9 installations only (64 bit). Override this at your own risk."
echo "In addition, some files may be overwritten. Please make sure you run this only on fresh installations."
sleep 10
echo "Checking if requirements are met..."
if [ "$USER" != "root" ]; then
	echo "Please re-run this installer as the root user."
	exit 1
fi
deb_ver=$(cat /etc/debian_version | grep "^[9]..")
if [ -z "$deb_ver" ]; then
	echo "Our records show that your operating system is either too old or not Debian based. Installation will not proceed."
	exit 2
fi
sleep 2
echo "Please enter the amount of RAM to allocate to your Minecraft server in megabytes."
read mcram
apt-get update -y
echo "Installing Java 8..."
sleep 2
apt-get install openjdk-8-jre -y
echo "Installing web server..."
sleep 2
apt-get install apache2 php7.0 -y
apt-get install php-xml -y
service apache2 restart
echo "Preparing directory structure..."
sleep 2
cd /var/www
apt-get install -yqq wget unzip zip screen
wget https://github.com/FlamesRunner/MCP/raw/master/slave/slave_final.zip
unzip -o slave_final.zip
cd /var/www/html
mkdir files
mv server/* files/
mv files server
sed -i 's/512/'"$mcram"'/g' /var/www/html/start.sh
sed -i 's/cd server/cd server\/files/g' /var/www/html/start.sh
echo "Creating appropriate users..."
sleep 2
chsh -s /bin/bash www-data
useradd -d /var/www/html/server minecraft
chsh -s /bin/bash minecraft
echo "Setting permissions and installing cronjob..."
sleep 2
chown minecraft:www-data -R /var/www/html/server/* && chmod 775 /var/www/html/server/* -R && chown root:root /var/www/html/server/.htaccess
apt-get install cron -yqq
crontab -l > /root/crontab.old
echo "* * * * * chown minecraft:www-data -R /var/www/html/server/* && chmod 775 /var/www/html/server/* -R && chown root:root /var/www/html/server/.htaccess && chown www-data:www-data /var/www/html/start.sh" >> /root/crontab.old
crontab /root/crontab.old
rm -rf /root/crontab.old
chown root:root /var/www # Ensure that the directories are setup correctly for SFTP jail
chown root:root /var/www/html
chown root:root /var/www/html/server
chmod 755 /var/www
chmod 755 /var/www/html
chmod 755 /var/www/html/start.sh
chown www-data:www-data /var/www/html/start.sh
echo "Configuring SSH server to chroot SFTP..."
sleep 2
wget https://raw.githubusercontent.com/FlamesRunner/MCP/master/slave/slave_ssh.txt -O /tmp/slave_ssh.txt
cp /etc/ssh/sshd_config /etc/ssh/sshd_config.bak
sed -i '/\/usr\/lib\/openssh\/sftp-server/d' /etc/ssh/sshd_config
cat /tmp/slave_ssh.txt >> /etc/ssh/sshd_config
echo "Restarting SSH server..."
sleep 2
service ssh restart
echo "Setting up keys..."
sleep 2
MCPASS=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 64 | head -n 1)
APIKEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 64 | head -n 1)
echo -e "$MCPASS\n$MCPASS" | passwd minecraft
sed -i 's/9dae50679c39a83142c81a389fb9b8e926905ecfe75d772b03f6d69947d76732/'"$APIKEY"'/g' /var/www/html/api.php
sed -i 's/04d99b2cca600c77b59b0bdeaea721a5baf0c60f914bda1716b7adc3a7785988/'"$MCPASS"'/g' /var/www/html/api.php
sleep 2
echo " "
echo "Installation complete."
echo "Please save the following API key. If you require it at a later time, please execute 'cat /var/www/html/api.php' and locate the key."
echo "Key $APIKEY"
