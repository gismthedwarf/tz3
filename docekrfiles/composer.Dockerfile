FROM composer:latest

WORKDIR /var/www/tz3

ENTRYPOINT ["composer", "--ignore-platform-reqs"]