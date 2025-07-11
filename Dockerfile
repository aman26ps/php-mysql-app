FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Install MySQL client tools
RUN apt-get update && apt-get install -y default-mysql-client

# Copy application files
COPY app/ /var/www/html/
COPY docker/init.sql /var/www/html/init.sql
COPY docker/entrypoint.sh /entrypoint.sh

# Permissions and entrypoint
RUN chmod +x /entrypoint.sh && \
    chown -R www-data:www-data /var/www/html

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
