FROM composer:latest

WORKDIR /var/www/library

ENTRYPOINT ["composer"]