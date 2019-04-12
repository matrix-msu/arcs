#!/bin/bash

# Create a horrible, no good, self signed default cert
/opt/local/bin/openssl req -x509 -nodes -subj '/CN=*' -newkey rsa:2048 -keyout /tmp/key.pem -out /tmp/cert.pem -days 365

# now contsturct and deliver that as a fall back certificate for haproxy

mkdir -p /opt/local/etc/certs/

cat /tmp/key.pem /tmp/cert.pem > /opt/local/etc/certs/aaaaaaaaa-default.cert

svcadm restart haproxy


