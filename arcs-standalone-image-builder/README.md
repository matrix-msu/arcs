# ARCS

## Image creation

```
packer build packer.json
```

## VM creation

```
triton instance create arcs g4-highcpu-1G
```

## Install

### ssh as root


```
Edit /home/node/Kora3/.env's first line to:
APP_ENV=local
```

```
php artisan install:finish localhost kora3 kora3 kora3 kora3_ admin admin admin admin@kora3.matrix.msu.edu password password Matrix en iggy.matrix.msu.edu kora3@matrix.msu.edu kora3 none none AAA AAA
```

```
chown -R node:www /home/node/Kora3
chmod -R 775 /home/node/Kora3
```

### ssh as node

```
cd /home/node/website/arcs/

mkdir app/tmp
chmod 777 app/tmp
chmod 777 app/Config/bootstrap.php
```
```
mysql -h localhost -u kora3 -pkora3 kora3 < kora3_arcs_install.sql 

```
```
mysql -h localhost -u arcs -parcs arcs < arcs_scheme.sql 
```

Go to the arcs website ( http://addressofhost/arcs/ ) and do inital configuration.

```
chmod 775 app/tmp
chmod 775 app/Config/bootstrap.php
```

### Finished

*
*
*

## Troubleshoot
See if you need to fix arcs database:

## Pre-configured databases
You shouldn't need these but if for some reason it isn't correct by default:

kora
```
hostname: localhost
database: kora3
username: kora3
password: kora3
prefix:   kora3_
```
arcs
```
/home/node/website/arcs/app/Config/database.php
hostname: localhost
database: arcs
username: arcs 
password: arcs 
prefix:   
```
