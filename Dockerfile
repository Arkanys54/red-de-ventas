# Imagen para desplegar la app Laravel 12 + MongoDB (Railway / Render / cualquier host Docker).
# Controla el entorno para garantizar las extensiones que faltan en los builders por defecto.
FROM php:8.2-cli

# Dependencias del sistema + herramientas para compilar extensiones
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl pkg-config \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libssl-dev \
    $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/*

# Extensiones de PHP (gd/zip/bcmath/exif para intervention/image, dompdf, phpword)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd zip bcmath exif

# Extensión MongoDB (requerida por mongodb/laravel-mongodb)
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node 20 para compilar los assets con Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY . .

# Dependencias de PHP (producción) y build del frontend
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build

# Permisos de escritura que Laravel necesita
RUN chmod -R 775 storage bootstrap/cache

# Railway/Render inyectan el puerto en $PORT
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
