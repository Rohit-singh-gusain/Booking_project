FROM php:8.1-apache


# Copy your PHP app
COPY . /var/www/html/

# Fix permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
