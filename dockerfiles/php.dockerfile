FROM php:8.0-fpm-alpine

WORKDIR /var/www/html

COPY teacher-app .

COPY student-app .

RUN docker-php-ext-install pdo pdo_mysql

RUN chown -R www-data:www-data /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer