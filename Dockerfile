FROM php:7.4-fpm-alpine
COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www

#CMD composer install && php-fpm
CMD sh -c "composer install && php-fpm"
EXPOSE 9000
