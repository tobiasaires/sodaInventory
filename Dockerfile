FROM ambientum/php:7.3-nginx

WORKDIR /var/www/app

USER root

RUN apk add --update nodejs nodejs-npm

USER ambientum
