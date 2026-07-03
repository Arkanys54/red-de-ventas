# Imagen para desplegar la app Laravel 12 + MongoDB (Render / Railway / cualquier host Docker).
# Controla el entorno para garantizar todas las extensiones de PHP que la app necesita.
FROM php:8.2-cli

# Instalador oficial de extensiones: resuelve dependencias del sistema automáticamente.
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# ext-mongodb fijada a 1.21 para coincidir con mongodb/mongodb 1.21.x del composer.lock
# (la serie 2.x no es compatible con esa versión bloqueada de la librería).
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions mongodb-1.21.1 gd zip bcmath exif mbstring pcntl intl

# Herramientas del sistema (git para composer, curl para node)
RUN apt-get update && apt-get install -y --no-install-recommends git unzip curl \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node 20 para compilar los assets con Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY . .

# Dependencias PHP (producción). --no-scripts evita que package:discover corra en el build.
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Frontend
RUN npm ci && npm run build

# Genera el manifiesto de paquetes (equivalente a lo que hace el script omitido)
RUN php artisan package:discover --ansi || true

# Permisos de escritura de Laravel
RUN chmod -R 775 storage bootstrap/cache

# Render/Railway inyectan el puerto en $PORT
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
