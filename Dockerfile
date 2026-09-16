FROM php:8.2-apache

WORKDIR /var/www/html

# Extensions PHP nécessaires à Symfony + MySQL
RUN apt-get update \
    && apt-get install -y unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour Symfony# Activer mod_rewrite
RUN a2enmod rewrite

# Configuration Apache pour Symfony
RUN printf '%s\n' \
'<VirtualHost *:80>' \
'    DocumentRoot /var/www/html/public' \
'' \
'    <Directory /var/www/html/public>' \
'        AllowOverride None' \
'        Require all granted' \
'        FallbackResource /index.php' \
'    </Directory>' \
'' \
'    ErrorLog ${APACHE_LOG_DIR}/error.log' \
'    CustomLog ${APACHE_LOG_DIR}/access.log combined' \
'</VirtualHost>' \
> /etc/apache2/sites-available/000-default.conf

# Configurer Apache pour utiliser /public comme DocumentRoot
# Activer mod_rewrite
RUN a2enmod rewrite

# Configuration Apache pour Symfony
RUN printf '%s\n' \
'<VirtualHost *:80>' \
'    DocumentRoot /var/www/html/public' \
'' \
'    <Directory /var/www/html/public>' \
'        AllowOverride None' \
'        Require all granted' \
'        FallbackResource /index.php' \
'    </Directory>' \
'' \
'    ErrorLog ${APACHE_LOG_DIR}/error.log' \
'    CustomLog ${APACHE_LOG_DIR}/access.log combined' \
'</VirtualHost>' \
> /etc/apache2/sites-available/000-default.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier les fichiers Composer
COPY composer.json composer.lock ./

# Copier le projet
COPY . .

# Installer les dépendances PHP
RUN composer install \
    --optimize-autoloader \
    --no-interaction



# Permissions Symfony
RUN mkdir -p var/cache var/log public/uploads \
    && chown -R www-data:www-data var public/uploads \
    && chmod -R 775 var public/uploads

EXPOSE 80

CMD ["apache2-foreground"]