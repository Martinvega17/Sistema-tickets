FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario y grupo para la aplicación
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar el código de la aplicación
COPY composer.json composer.lock /var/www/html/
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
COPY . /var/www/html

# Copiar el archivo de configuración personalizado si existe
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Cambiar propietario del directorio
RUN chown -R www:www /var/www/html

# Cambiar al usuario www
USER www

# Exponer el puerto 9000 y ejecutar php-fpm
EXPOSE 9000
CMD ["php-fpm"]