#!/bin/sh

sudo certbot \
    -n \
    --nginx \
    --agree-tos \
    -d nibo-admin.polen.me \
    --email rodolfo.neto@polen.me