# ARCS

## Image creation

```
packer build packer.json
```

## VM creation

```
triton instance create arcs g4-highcpu-1G
```

Use web interface to install kora3 or by command line.  Command line example uses settings that are valid at Matrix, not in general.
*You must be signed in as root to run the following command:

```
php artisan install:finish localhost kora3 kora3 kora3 kora3_ admin admin admin admin@kora3.matrix.msu.edu password password Matrix en iggy.matrix.msu.edu kora3@matrix.msu.edu kora3 none none AAA AAA
```

Pre-configured databases exist for kora3.
```
hostname: localhost
database: kora3
username: kora3
password: kora3
prefix:   kora3_
```

*Sign in as node to do everything below here-
Load the ARCS bootstrap data into your now configured kora3

```
[node@nonaka-47 ~/website/arcs]$ mysql -h localhost -u kora3 -pkora3 kora3 < kora3_arcs_install.sql 

```

Load the ARCS bootstrap data into the arcs database
```
[node@nonaka-47 ~/website/arcs]$ mysql -h localhost -u arcs -parcs arcs < arcs_scheme.sql 
```

Fix the ARCS database configuration in /home/node/website/arcs/app/Config/database.php

Pre-configured database for arcs.
```
hostname: localhost
database: arcs
username: arcs 
password: arcs 
prefix:   
```
Run these commands from the node user to prepare for the web install process.
```
cd ~/website/arcs/app/
mkdir tmp
chmod 777 tmp
chmod 777 Config/bootstrap.php
```


Go to the arcs website ( http://addressofhost/arcs/ ) and do inital configuration.

