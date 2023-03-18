# 6130comp-project-CMPJTHO1

## A Runners Crisps Project

This project is a web application with load balancers using NGINX and `docker-compose.yaml` file that contains multiple nodes for high availability. The web application includes a form using a prize draw system with unique 10-digit voucher codes for customers to win discounts on Runners Crisps or a voucher for The European cup final football game. The application follows the N-tier architecture and uses a MongoDB replica set for storing user data and voucher codes, providing a scalable and robust solution for managing high traffic loads.

## Presentation Tier

The structure of presentation is the front-end that includes a load balancer directory, Dockerfile and an nginx configuration file. The source directory also contains HTML, PHP, and CSS asset files. The form structure is located at `form.php` that handles the $response request from back-end (business logic).

## Business logic Tier

Business directory handles the form logic response `logic.php` from the presentation tier where user data, voucher codes, is sanitized and validated to ensure its authenticity and get's stored in the MongoDB replica set. The logic also handles voucherCodes to be used once and marks them as used once the form is submitted. The business logic URL contains the docker containers using NGINX load balancer - `http://backend_loadbalancer:4000/logic.php`

## Data Tier

Data tier includes `setup.js` that creates the MongoDB database replica sets (3) with Mongo1 being the primary database. The file `init.js` is where the user data is stored and the generation of 10-digit hexdecimal voucher code for football and discount.

## Prerequisites

You must have Docker installed on your system to proceed with the installation and testing. *It is recommended that you clone this project within a WSL or Linux VM with Docker installed for the following guide.*

Install Docker-compose

`https://www.docker.com/products/docker-desktop/`

Start up Docker daemon services.

`sudo systemctl start docker`

## Installation

clone the repo 

`git clone https://github.com/jacllyr/6130comp-project.git`

cd inside the root folder 

`cd 6130comp-project`

Update the distro packages

`sudo apt update`

Start the docker container

`docker-compose up`

Open the webite form application 

`http://localhost:80`

To stop services

`docker-compose down` or `CTRL C`

## Testing

To test the three available shell test scripts individually, please follow the steps below. Note that the MongoDB replica set is being initialized, so please allow 30 seconds for the script to run:

cd to root of project for execution.

`cd 6130comp-project`

### Football Voucher

Automated testing - `sudo bash test_voucher.sh`

Manual testing form - `1234567890`

### 10% Discount Voucher

Automated testing - `sudo bash test_discount.sh`  

Manual testing form -  `1111111111`

### Used Voucher

Automated testing - `sudo bash test_used.sh`

Manual testing form - `2222222222`




