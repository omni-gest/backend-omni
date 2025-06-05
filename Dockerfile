# Etapa base: PHP 8.2 com extensões comuns para Laravel
FROM php:8.2-cli

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . .

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

RUN cat /app/backend-omni/app/Repositories/EstoqueRepository.php

# Gera a key da aplicação
RUN php artisan key:generate

# Roda as migrations (aqui assume que o banco já está acessível)
RUN php artisan migrate

# Exponha a porta padrão do Laravel
EXPOSE 3333

# Sobe o servidor embutido do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3333"]
