FROM php:8.4-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev libjpeg-turbo-dev freetype-dev libwebp-dev \
    libzip-dev oniguruma-dev libxml2-dev \
    nodejs npm \
    autoconf make g++ $PHPIZE_DEPS

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Redis (latest stable, compatible with PHP 8.4)
RUN pecl install redis \
    && docker-php-ext-enable redis \
    && apk del autoconf make g++ $PHPIZE_DEPS

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Cache composer layer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist

# Copy app
COPY . .

# Build frontend
RUN npm ci --legacy-peer-deps \
    && npm run build \
    && rm -rf node_modules

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
