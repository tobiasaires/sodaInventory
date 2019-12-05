#!/bin/bash
echo [+] Copying the configuration example file
cp .env.example .env

echo [+] Uploading Application Container
docker-compose up -d

echo [+] Installing the dependencies
docker-compose exec app composer install
docker-compose exec app npm install


echo [+] Generating key
docker-compose exec app php artisan key:generate


echo [+] Information of new containers
docker ps

