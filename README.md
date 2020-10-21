ARCS
====
ARCS is an open-source web platform that enables individuals to collaborate in
creating and relating digitized primary evidence when conducting research in
the humanities.

Installation Instructions:

ARCS is known to operate on Ubuntu 18.04 LTS.  ARCS can also operate on 
Joyent SmartOS, which is where primary development was done.  The underlying 
requirements for ARCS are PHP 7.2, Apache, MySQL, and Kora 
(https://github.com/matrix-msu/kora). While the install can be done by hand, 
and for advanced configuration is recommended, for simple installs, an 
automated installer for Ubuntu Server 18.04 LTS has been created.  

Requirements for the installer include having a domain name assigned to your
empty Ubuntu 18.04 LTS server install.  ARCS and Kora both require https 
connections with valid certificates.  The automatic installer will use ACME
to aquire Let's Encrypt certificates at the name you specify.  Without an
active domain name pointing to your server, the install sequence will fail.

The installer is tested to function on an fresh and otherwise empty Ubuntu
18.04 LTS server.  Using the automated installer on an existing populated
server will have undefined behavior.  Do not run the install script on a
server with a configuration or data you value.

The following commands will download and run the automatic installer on 
Ubuntu Server.

```
curl https://raw.githubusercontent.com/matrix-msu/arcs/master/arcs-installer.sh -o arcs_installer.sh
chmod 775 arcs_installer.sh
./arcs_installer.sh
```
