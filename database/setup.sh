#!/bin/bash

echo "Creating MongoDB database..."

# 5 second delay for letting the docker containers being initialized
sleep 5

# Create a mongodb replica set
mongosh --host mongo1:27017 <<EOF
var config = {
    "_id": "rs0",
    "version": 1,
    "members": [
        {
            "_id": 0,
            "host": "mongo1:27017",
            "priority": 2
        },
        {
            "_id": 1,
            "host": "mongo2:27017",
            "priority": 0
        },
        {
            "_id": 2,
            "host": "mongo3:27017",
            "priority": 0
        }
    ]
};
rs.initiate(config, { force: true });
EOF

# Short delay to create the generated voucher codes in init.js
sleep 15

mongosh --host mongo1:27017 </database/init.js

# Mongo-setup never sleeps
exec tail -f /dev/null
