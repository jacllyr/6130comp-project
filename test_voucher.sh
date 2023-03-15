#!/bin/bash

echo "Waiting for services to start..."

# Start services
docker-compose up -d

# Wait for services to start
echo "Please allow 30 seconds to test the VOUCHER script..."

sleep 30

# Test the form submission
RESULT=$(curl --request POST \
  --url http://localhost:4000/logic.php \
  --header 'Content-type: application/x-www-form-urlencoded' \
  --data-urlencode 'voucherCode=1234567890' \
  --data-urlencode 'bestPlayer=Fernando Torres' \
  --data-urlencode 'fullName=Jac Llyr' \
  --data-urlencode 'email=cmpjtho1@ljmu.ac.uk.com' \
  --data-urlencode 'address=James Parsons Building, Byrom Street, Liverpool L3 3AF' \
  --data-urlencode 'submit')

echo "Result is $RESULT and we expect VOUCHER"

sleep 10

echo "Stopping services..."

# Stop services
docker-compose down
