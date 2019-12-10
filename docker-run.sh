#!/bin/bash
echo [+] Copying the configuration example file
cp .env.example .env

echo [+] Uploading Application Container
docker-compose up -d --build

echo [+] Installing the dependencies
docker-compose exec app composer install


echo [+] Generating key
docker-compose exec app php artisan key:generate

echo [+] Running tests

docker-compose exec app sh -c "./vendor/phpunit/phpunit/phpunit tests/Feature/SodaTest.php"

echo [+] Information of new containers
docker ps

