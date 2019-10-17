#!/bin/bash

echo "Configure postgresql server!"

psql --version

# psql -c "CREATE USER root SUPERUSER WITH PASSWORD 'password';" -U postgres
psql -c "CREATE DATABASE logs_testing;" -U postgres


