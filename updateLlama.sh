#!/bin/sh
cd llama.cpp
git config --global --add safe.directory /var/www/html/ziptie/llama.cpp
git stash
git pull origin master
make
