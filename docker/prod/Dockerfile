FROM php:8.4-cli-bookworm

ARG WWWGROUP=1000

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/local/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        gosu \
        libcap2-bin \
        libfreetype6 \
        libfreetype6-dev \
        libicu72 \
        libicu-dev \
        libjpeg62-turbo \
        libjpeg62-turbo-dev \
        libpng16-16 \
        libpng-dev \
        libzip4 \
        libzip-dev \
        supervisor \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        intl \
        pcntl \
        pdo_mysql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && setcap "cap_net_bind_service=+ep" /usr/local/bin/php \
    && groupadd --force -g "$WWWGROUP" sail \
    && useradd -ms /bin/bash --no-user-group -g "$WWWGROUP" -u 1337 sail \
    && git config --global --add safe.directory /var/www/html \
    && apt-get purge -y --auto-remove \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
    && apt-get install -y --no-install-recommends \
        libfreetype6 \
        libicu72 \
        libjpeg62-turbo \
        libpng16-16 \
        libzip4 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /usr/local/etc/php/conf.d/99-app.ini
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
