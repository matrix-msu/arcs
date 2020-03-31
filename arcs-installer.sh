clear
echo ""
echo "Welcome to the ARCS installer!"
echo ""
echo "This installer currently supports Ubuntu 18.04.2 LTS (Bionic Beaver)."
echo ""
echo "Would you like to continue?"
echo ""

read -p "[yes/no]? " input

case $input in
        [yY][eE][sS]|[yY])
                echo ""
                echo ""
                echo "Okay!"
                echo ""
                ;;
        *)
                echo "Stopping."
                exit 1
                ;;
esac

echo "We just need to get a couple pieces of information from you to get started."
echo ""
echo ""
echo "Please enter the domain your server is on:"
echo "Ex. projects.arcs.matrix.msu.edu"
echo ""

read -p "Domain: " domain

echo ""

echo "We also need an email address for your ARCS and KORA admin account."
echo ""
echo "Please enter your email accounts' address:"
echo "Ex. arcs.example@gmail.com"
echo ""

read -p "Email Address: " emailAddress

echo ""

echo ""
echo "Please enter your email accounts' password:"
echo ""

read -p "Email Password: " emailPassword

echo ""
echo "Please confirm all of the following information:"
echo ""
echo "Install url:              https://$domain"
echo "Admin Email:              $emailAddress"
echo "Admin Email Password:     $emailPassword"
echo ""

read -p "Is it all correct [yes/no]? " input
echo ""

case $input in
        [yY][eE][sS]|[yY])
                echo "Starting installation!"
                echo ""
                ;;
        *)
                echo "Stopping."
                exit 1
                ;;
esac


sudo apt-get update

sudo apt -y install software-properties-common
sudo add-apt-repository ppa:certbot/certbot -y
sudo apt-get update

sudo apt-get -y install apache2
sudo apt-get -y install mysql-server

sudo apt -y install php7.2 php7.2-common php7.2-mysql php7.2-xml php7.2-xmlrpc php7.2-curl php7.2-gd php7.2-imagick php7.2-cli php7.2-dev php7.2-imap php7.2-mbstring php7.2-opcache php7.2-soap php7.2-zip php7.2-intl

sudo usermod -a -G www-data ubuntu
sudo chown -R ubuntu:www-data /var/www/html/

sudo ufw allow 'Apache Full'
sudo ufw allow 'OpenSSH'

sudo apt -y install python-certbot-apache

sudo apache2ctl configtest
sudo systemctl reload apache2

sudo certbot -n --agree-tos --redirect --apache -d $domain -m $emailAddress

sudo rm -rf /var/www/html/*

git clone https://github.com/matrix-msu/arcs.git /var/www/html/
cd /var/www/html/
git checkout d5ba097541e625198bc14892c77e90ed8ce406d0

git clone https://github.com/matrix-msu/Kora3.git /var/www/html/kora-config/
cd /var/www/html/kora-config
git checkout df5d77f853d5e7631af86b1adac88a7bbd397c8d

touch /var/www/html/installerInput.txt
echo "$domain" | sudo tee -a /var/www/html/installerInput.txt
echo "$emailAddress" | sudo tee -a /var/www/html/installerInput.txt
echo "$emailPassword" | sudo tee -a /var/www/html/installerInput.txt

ln -s /var/www/html/kora-config/public /var/www/html/kora
cp /var/www/html/kora/.htaccess.example /var/www/html/kora/.htaccess
sudo chmod -R 775 /var/www/html/kora-config/
cp /var/www/html/kora-config/.env.example /var/www/html/kora-config/.env

sudo mysql <<QUERY_INPUT
create database kora;
GRANT ALL ON kora.* TO 'kora'@'localhost' IDENTIFIED BY 'kora';
flush privileges;
exit
QUERY_INPUT

cd /var/www/html/kora-config
php artisan kora:install

sudo chown -R www-data /var/www/html/kora-config/bootstrap/cache/
sudo chown -R www-data /var/www/html/kora-config/storage/
sudo chown -R www-data /var/www/html/kora-config/public/assets/javascripts/production/

mysql -u kora -pkora kora < /var/www/html/kora3_arcs_install.sql

sudo touch tempFile
sudo chmod 777 tempFile
htpasswd -cbBC 10 tempFile "" $emailPassword | tr -d ':\n'
sed '1s/^.//' tempFile > hashedFile
hashedPass=`cat hashedFile`
rm tempFile
rm hashedFile

sudo mysql <<QUERY_INPUT
use kora;
update kora_users set email="$emailAddress", password="$hashedPass" where username="admin";
exit
QUERY_INPUT

sudo sed -i '$ d' /etc/apache2/sites-available/000-default-le-ssl.conf
echo -e "<Directory /var/www/html>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n</IfModule>" | sudo tee -a /etc/apache2/sites-available/000-default-le-ssl.conf

sudo a2enmod headers
sudo service apache2 restart
sudo systemctl restart apache2

cp /var/www/html/.htaccess.dist.arcspath /var/www/html/.htaccess
cp /var/www/html/app/.htaccess.dist.arcspath /var/www/html/app/.htaccess
cp /var/www/html/app/webroot/.htaccess.dist.arcspath /var/www/html/app/webroot/.htaccess

sudo mysql <<QUERY_INPUT
create database arcs;
GRANT ALL ON arcs.* TO 'arcs'@'localhost' IDENTIFIED BY 'arcs';
flush privileges;
exit
QUERY_INPUT

mysql -u arcs -parcs arcs < /var/www/html/arcs_scheme.sql

cp /var/www/html/app/Config/bootstrap.dist.template.php  /var/www/html/app/Config/bootstrap.php
mkdir /var/www/html/app/tmp

chmod 777 /var/www/html/app/Config/bootstrap.php
chmod 777 /var/www/html/app/tmp
