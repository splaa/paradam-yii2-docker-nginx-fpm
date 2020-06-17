FROM yiisoftware/yii-php:7.4-apache
USER root

RUN apt-get update && apt-get install -y openssh-server apache2 supervisor
RUN mkdir -p /var/lock/apache2 /var/run/apache2 /var/run/sshd /var/log/supervisor

#RUN mkdir /var/log/telegram/
RUN mkdir /var/log/websocket/
COPY conf.d/supervisord.conf /etc/supervisor/supervisord.conf
#COPY conf.d/telegram_api_server.conf /etc/supervisor/conf.d/telegram_api_server.conf
COPY conf.d/websocket_server.conf /etc/supervisor/conf.d/websocket_server.conf
COPY conf.d/domain.crt /etc/ssl/certs/domain.crt
COPY conf.d/domain.key /etc/ssl/key/domain.key
COPY conf.d/apache_ssl.conf /etc/apache2/sites-available/new-default-ssl.conf

EXPOSE 80
EXPOSE 443
EXPOSE 9503
EXPOSE 9505
