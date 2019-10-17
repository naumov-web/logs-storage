#!/bin/bash

echo "Installing postgresql 11.3 server!"

sudo apt-get update
sudo apt-get --yes remove postgresql\*
sudo apt-get install -y postgresql-11 postgresql-client-11
sudo cp /etc/postgresql/{9.6,11}/main/pg_hba.conf
sudo service postgresql restart 11
