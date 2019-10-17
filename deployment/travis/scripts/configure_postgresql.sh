#!/bin/bash

echo "Configure postgresql server!"

psql --version

psql -c "CREATE ROLE root SUPERUSER LOGIN;" -U postgres
psql -c "CREATE DATABASE logs_testing;" -U postgres


