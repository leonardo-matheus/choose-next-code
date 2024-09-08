FROM mcr.microsoft.com/vscode/devcontainers/php:latest

# Instalar dependências adicionais
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Configurar PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd
