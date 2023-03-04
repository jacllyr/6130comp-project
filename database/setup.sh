#!/bin/bash

echo "Creating MongoDB database..."

sleep 10

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

sleep 5

mongosh --host mongo1:27017 </database/init.js
