clear
echo ""
echo "Welcome to the ARCS installer!"
echo ""
echo "This installer currently only officially supports Ubuntu 18.04.2 LTS (Bionic Beaver)."
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

echo "We just need to know the domain your server is on to get started."
echo ""
echo "Ex. projects.arcs.matrix.msu.edu"
echo ""

read -p "Domain: " domain

echo ""

echo ""
echo "Please confirm that you would like to start an ARCS installation at the following url:"
echo ""
echo "https://$domain"
echo ""

read -p "[yes/no]? " input
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
sudo add-apt-repository ppa:certbot/certbot
sudo apt-get update

sudo apt-get -y install apache2
sudo apt-get -y install mysql-server

sudo apt -y install php7.3 php7.3-common php7.3-mysql php7.3-xml php7.3-xmlrpc php7.3-curl php7.3-gd php7.3-imagick php7.3-cli php7.3-dev php7.3-imap php7.3-mbstring php7.3-opcache php7.3-soap php7.3-zip php7.3-intl

sudo usermod -a -G www-data ubuntu
sudo chown -R ubuntu:www-data /var/www/html/

sudo ufw allow 'Apache Full'
sudo ufw allow 'OpenSSH'

sudo apt -y install python-certbot-apache

sudo apache2ctl configtest
sudo systemctl reload apache2

sudo certbot -n --test-cert --agree-tos --redirect --apache -d $domain -m matrix@msu.edu

sudo rm -rf /var/www/html/*

git clone https://github.com/matrix-msu/arcs.git /var/www/html/
git clone https://github.com/matrix-msu/Kora3.git /var/www/html/kora-config/

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
