#!/usr/bin/bash

PASSWORD=`/usr/bin/uuid`
echo $PASSWORD | /usr/sbin/mdata-put mysql_pw 

/opt/local/bin/mysql -u root <<-EOF
UPDATE mysql.user SET authentication_string=PASSWORD('$PASSWORD') WHERE User='root';
FLUSH PRIVILEGES;
EOF


