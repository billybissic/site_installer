#!/bin/bash
#apt -y install software-properties-common
#add-apt-repository ppa:ondrej/php

[[ $EUID -ne 0 ]] && echo "This script must be run as root." && exit 1

#configuration
DOMAIN_NAME='yourdomain.com'
SCRIPT_HOME=`pwd`
TOMCAT_DOWNLOAD_PATH=https://downloads.apache.org/tomcat/tomcat-9/v9.0.46/bin/apache-tomcat-9.0.46.tar.gz
SERVER_NAME="server name"
WEB_MASTER="webmaster@yourdomain.com"
WEB_SERVER_NAME="server-name"
WEB_SITE_PORT=80
BACKEND_SERVICES_REPO=""
FONT_END_REPO=""
DATABASE_INSTALLER_REPO=""

echo "Updating System"
apt-get update

echo "Installing apache2"
apt install -y apache2

#Installing MySQL
echo "Installing MySQL"
apt install -y mysql-server

#Installing PHP as it's needed for the rest of the installation
echo "Installing PHP"
apt install -y php libapache2-mod-php php-mysql
apt install -y php-cli php-json php-common php-zip php-gd php-mbstring php-curl php-xml php-bcmath
#apt install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath

#Configure Apache2
echo "Configuring Apache2"
$(mkdir /var/www/${DOMAIN_NAME})
$(chown -R $USER:$USER /var/www/${DOMAIN_NAME})
#Write DOMAIN_NAME.conf file for sites-available
php writeVirtualHost.php -d ${DOMAIN_NAME} -w ${WEB_MASTER} -n WEB_SERVER_NAME -p ${WEB_SITE_PORT}
$(cp ${DOMAIN_NAME}.conf /etc/apache2/sites-available/${DOMAIN_NAME}.conf)
$(a2ensite ${DOMAIN_NAME})
a2dissite 000-default
apache2ctl configtest
systemctrl reload apache2

#Write index page to domain
echo "Creating site index.html file"
$(php writeSiteIndex.php -d ${DOMAIN_NAME})
$(cp index.html /var/www/${DOMAIN_NAME}/index.html)

#OPTIONAL- edit the mods-enabled on apache2 to allow PHP to be accessed
$(php writeModsEnabledDirConf.php)
cp /etc/apache2/mods-enabled/dir.conf /etc/apache2/mods-enabled/dir.conf.bak
cp dir.conf /etc/apache2/mods-enabled/dir.conf

systemctrl reload apache2

#Installing JAVA JRE and JDK
echo "Installing Java JRE & JDK"
apt install -y default-jre
apt install -y default-jdk

#Installing MySQL
echo "Installing MySQL"
apt install -y mysql-server

#Installing Tomcat 9
echo "Installing Tomcat 9"
groupadd tomcat
useradd -s /bin/false -g tomcat -d /opt/tomcat tomcat
cd /tmp
$(wget -c ${TOMCAT_DOWNLOAD_PATH}) 
mkdir /opt/tomcat
tar xzvf apache-tomcat-9*tar.gz -C /opt/tomcat --strip-components=1
cd -
cd /opt/tomcat
chgrp -R tomcat /opt/tomcat
chmod -R g+r conf
chmod g+x conf
chown -R tomcat webapps/ work/ temp/ logs/
cd -
#$(cd ${SCRIPT_HOME})

#Installing Maven
echo "Installing Apache Maven"
apt install -y maven

#Installing NodeJs
echo "Install NodeJs & NPM"
apt install -y nodejs
apt install -y npm

#Installing GIT
echo "Installing GIT"
apt install -y git-all

#Installing figlet
echo "Installing Figlet"
apt install -y figlet

#Installing ansi weather
echo "Installing ansi-weather"
apt install -y ansiweather

#Creating Custom MOTD
echo "Creating custom MOTD"
#$(cd ${SCRIPT_HOME})
php writeCustomMOTD.php -n "${SERVER_NAME}"
pwd
chmod -x /etc/update-motd.d/*
cp 01-Custom /etc/update-motd.d/01-Custom
chmod +x /etc/update-motd.d/01-Custom

#Download Source 
echo "Downloading Source Code"
