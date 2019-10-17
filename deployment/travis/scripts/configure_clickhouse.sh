#!/bin/bash

echo "Configure clickhouse server!"

sudo rm /etc/clickhouse-server/config.xml
sudo cp ./deployment/travis/configs/clickhouse-main.xml /etc/clickhouse-server/config.xml
sudo cp ./deployment/travis/configs/clickhouse-user.xml /etc/clickhouse-server/users.d/local_user.xml

sudo service clickhouse-server restart
