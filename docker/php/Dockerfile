FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

# スクリプトファイルをコピー
COPY entrypoint.sh /tmp/
COPY cron.sh /root/script/

RUN apt-get update \
    && apt-get install -y \
    default-mysql-client\
    zlib1g-dev\
    libzip-dev\
    unzip\
    cron\
    mariadb-client\
    libfreetype6-dev\
    libjpeg62-turbo-dev\
    libpng-dev\
    && docker-php-ext-install pdo_mysql zip gd

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# crontabに登録
RUN echo '* * * * * sh /root/script/cron.sh' > /var/spool/cron/crontabs/root
RUN crontab /var/spool/cron/crontabs/root

# エントリーポイントの設定
ENTRYPOINT ["/tmp/entrypoint.sh"]

WORKDIR /var/www