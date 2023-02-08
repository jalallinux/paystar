FROM jalallinux/laravel-9:php-80

COPY . /var/project

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/project

COPY .env.docker .env
RUN composer install

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
