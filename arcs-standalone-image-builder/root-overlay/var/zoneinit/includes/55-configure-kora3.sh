#!/usr/bin/bash

PASSWORD=`/usr/sbin/mdata-get mysql_pw`
/opt/local/bin/mysql -p$PASSWORD -u root <<-EOF
CREATE DATABASE kora3;
GRANT ALL ON kora3.* TO 'kora3'@'localhost' IDENTIFIED BY 'kora3';
EOF

