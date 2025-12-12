# Usar una imagen de PHP 8.2 con soporte para Apache
FROM php:8.2-apache

# Instalar dependencias necesarias para Laravel y Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    software-properties-common \
    zip \
    curl \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js y npm (versión 18.x)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Instalar Vite globalmente
RUN npm install -g vite

# Copiar configuración de Apache personalizada
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite y reiniciar Apache
RUN a2enmod rewrite && service apache2 restart

# Establecer el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copiar los archivos de la aplicación Laravel al contenedor
COPY . .

# Copiar el archivo composer.lock y composer.json para instalar dependencias
COPY composer.lock composer.json /var/www/html/

# Instalar Composer con una versión compatible
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias de Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Instalar dependencias de Node.js, incluidas las relacionadas con Tailwind
RUN npm cache clean --force && npm install --legacy-peer-deps

# Instalar TailwindCSS, PostCSS y Autoprefixer
RUN npm install tailwindcss postcss autoprefixer

# Compilar el frontend con Vite
RUN npm run build

# Cambiar los permisos de las carpetas storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/public

# Exponer el puerto 80 para Apache
EXPOSE 80

# Iniciar Apache directamente
CMD ["apache2-foreground"]
