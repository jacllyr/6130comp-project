# 6130comp-project-CMPJTHO1

# A Runners Crisps Project

This project is a web application with load balancers using NGINX and multiple nodes for high availability. It includes a prize draw system with unique 10-digit voucher codes for customers to win discounts on Runners Crisps or a voucher for The European cup final football game. The application follows the N-tier architecture and uses a MongoDB replica set for storing user data and voucher codes, providing a scalable and robust solution for managing high traffic loads.

# Installation

Update the distro packages

`sudo apt update`

Install docker-compose

`sudo apt install docker-compose`

Start the docker container

`docker-compose up`

## Presentation Tier

The structure of presentation is the front-end that includes a load balancer directory, Dockerfile and an nginx configuration file. The web directory with a Dockerfile and a source code directory containing HTML, PHP, and CSS asset files for the form.


## Business logic Tier

Business directory handles the form logic response `logic.php` from the presentation tier, where user data, including voucher codes, is sanitized and validated to ensure its authenticity and get's stored in the MongoDB replica set.

## Data Tier

Data tier includes the MongoDB database replica set where the user data is stored and the generation of 10-digit hexdecimal code for voucherCodes in `init.js`
