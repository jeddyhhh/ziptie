#!/bin/sh
git config --global --add safe.directory /var/www/html/ziptie
git stash
git pull origin main
