# 6130comp-project-CMPJTHO1

## A Runners Crisps Project

This project is a web application with load balancers using NGINX and multiple nodes for high availability. It includes a prize draw system with unique 10-digit voucher codes for customers to win discounts on Runners Crisps or a voucher for The European cup final football game. The application follows the N-tier architecture and uses a MongoDB replica set for storing user data and voucher codes, providing a scalable and robust solution for managing high traffic loads.

## Presentation Tier

The structure of presentation is the front-end that includes a load balancer directory, Dockerfile and an nginx configuration file. The source directory also contains HTML, PHP, and CSS asset files. The form structure is located at `form.php` that handles the $response request from back-end (business logic).


## Business logic Tier

Business directory handles the form logic response `logic.php` from the presentation tier where user data, voucher codes, is sanitized and validated to ensure its authenticity and get's stored in the MongoDB replica set. The logic also handles voucherCodes to be used once and marks them as used once the form is submitted.

## Data Tier

Data tier includes `setup.js` that creates the MongoDB database replica with Mongo1 being the primary database. The file `init.js` is where the user data is stored and the generation of 10-digit hexdecimal voucher code for football and discount.

## Installation

Update the distro packages

`sudo apt update`

Install docker-compose

`sudo apt install docker-compose`

Start the docker container

`docker-compose up`

## Testing

There are 3 shell test script available to test.  Please follow the below to test them invidually -

cd to root for execution ./6130comp-project

### Football Voucher

Code for football voucher - `1234567890`

`sudo bash test_voucher.sh`

### Used Voucher

Code for used voucher - `2222222222`

`sudo bash test_used.sh`

### 10% Discount Voucher 

Code for discount voucher - `1111111111`

`sudo bash test_discount.sh`
