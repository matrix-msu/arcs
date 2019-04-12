#!/usr/bin/bash

PASSWORD=`/usr/sbin/mdata-get mysql_pw`
/opt/local/bin/mysql -p$PASSWORD -u root <<-EOF
CREATE DATABASE arcs;
GRANT ALL ON arcs.* TO 'arcs'@'localhost' IDENTIFIED BY 'arcs';
EOF

/opt/local/bin/mysql -u arcs -parcs arcs < /home/node/website/arcs/arcs_scheme.sql

/opt/local/bin/mysql -p$PASSWORD -u root arcs <<-EOF
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
EOF

su node -c 'cd /home/node/website/arcs/; cp .htaccess.dist.arcspath .htaccess; cd app; cp .htaccess.dist.arcspath .htaccess; cd webroot; cp .htaccess.dist.arcspath .htaccess'
su node -c 'cd /home/node/website/arcs/app/Config; cp bootstrap.dist.template.php bootstrap.php'
su node -c 'cd /home/node/website/arcs/app/; mkdir tmp; chmod 777 tmp'




