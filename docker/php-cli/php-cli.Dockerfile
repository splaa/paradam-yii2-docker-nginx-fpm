FROM php:7.4-cli
RUN apt-get update && apt-get install -y wget

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www/api
