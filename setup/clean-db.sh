#!/bin/sh

mysql -u root -p -e "DROP DATABASE musika; CREATE DATABASE musika;"
mysql -u root -p < tables.sql
