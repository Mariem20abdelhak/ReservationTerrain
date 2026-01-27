FROM heroku/heroku:22-build as base

# Create app directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP and dependencies
RUN apt-get update && apt-get install -y \
    php8.1 \
    php8.1-cli \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-curl \
    php8.1-zip \
    php8.1-intl \
    composer \
    && rm -rf /var/lib/apt/lists/*

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application code
COPY . .

# Set permissions
RUN chmod -R 755 var/ && chmod -R 755 public/uploads/

# Build final image
FROM heroku/heroku:22

WORKDIR /app

# Install PHP runtime
RUN apt-get update && apt-get install -y \
    php8.1 \
    php8.1-cli \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-curl \
    php8.1-zip \
    php8.1-intl \
    apache2 \
    && rm -rf /var/lib/apt/lists/*

# Copy from builder
COPY --from=base /app .

# Set environment
ENV PORT=8080 \
    APP_ENV=prod \
    LOG_CHANNEL=stdout

EXPOSE 8080

CMD ["vendor/bin/heroku-php-apache2", "-i", "/etc/apache2/mods-available/ssl.load", "public/"]
