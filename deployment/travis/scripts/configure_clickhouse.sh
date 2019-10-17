#!/bin/bash

echo "Configure clickhouse server!"

sudo cp ./deployment/travis/configs/clickhouse-user.xml /etc/clickhouse-server/users.d/local_user.xml

sudo service clickhouse-server restart
