#!/bin/sh

sudo certbot \
    -n \
    --nginx \
    --agree-tos \
    -d superteam-3.us-east-2.elasticbeanstalk.com \
    --email rodolfo.neto@polen.me