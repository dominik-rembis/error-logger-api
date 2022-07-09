FROM error-logger-api-base as error-logger-api-dev

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./docker/dev/vhost.conf /etc/apache2/sites-available/error-logger-api.conf

RUN a2ensite error-logger-api

COPY ./docker/dev/custom-php.ini $PHP_INI_DIR/conf.d/
