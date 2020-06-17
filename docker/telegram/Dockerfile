FROM ubuntu:latest AS base

RUN apt-get update \
	&& apt-get install --assume-yes git \
    && apt-get install -y \
        nmap \
        vim

RUN git clone https://github.com/xtrime-ru/TelegramApiServer.git
WORKDIR /TelegramApiServer

FROM composer:latest AS build
COPY --from=base /TelegramApiServer /TelegramApiServer
WORKDIR /TelegramApiServer
RUN composer install -o --no-dev

FROM php:7-alpine AS final
EXPOSE 9503
COPY --from=build /TelegramApiServer /telegram

RUN apk add --no-cache bash

RUN rm -rf telegram/examples/
RUN sed -i 's/TELEGRAM_API_ID=/TELEGRAM_API_ID=257313/g' telegram/.env.example
RUN sed -i 's/TELEGRAM_API_HASH=/TELEGRAM_API_HASH=ff458dd210d0e2d278d802b87da8d3cb/g' telegram/.env.example
RUN sed -i 's/SERVER_ADDRESS=127.0.0.1/SERVER_ADDRESS=0.0.0.0/g' telegram/.env.example
RUN sed -i 's/IP_WHITELIST=127.0.0.1/IP_WHITELIST=/g' telegram/.env.example
RUN sed -i 's/LOGGER_LEVEL=3/LOGGER_LEVEL=5/g' telegram/.env.example
#RUN sed -i 's/TELEGRAM_PROXY_ADDRESS=/TELEGRAM_PROXY_ADDRESS=188.134.77.205/g' telegram/.env.example
#RUN sed -i 's/TELEGRAM_PROXY_PORT=/TELEGRAM_PROXY_PORT=7777/g' telegram/.env.example
RUN mv telegram/.env.example telegram/.env

ENTRYPOINT ["php", "telegram/server.php"]