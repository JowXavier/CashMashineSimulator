FROM php:8.0-fpm

# Set working directory
WORKDIR /var/www/html

# Instalar dependências
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    build-essential \
    libfreetype6-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl \
    librdkafka-dev

# Instalar extensões
RUN docker-php-ext-install mysqli pdo_mysql
RUN pecl install rdkafka

# Habilitar no php.ini
RUN ln -s /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    echo "extension=rdkafka.so" >> /usr/local/etc/php/php.ini

# Instalar e habilitar Redis
RUN pecl install redis && docker-php-ext-enable redis

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Adicionar usuário para aplicação
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar o conteúdo do diretório de aplicativos existente
COPY . /var/www/html

# Copiar permissões existentes do diretório de aplicativos
COPY --chown=www:www . /var/www/html

# Alterar usuário atual para www
USER www

# Expor a porta 9000 e iniciar o servidor php-fpm
EXPOSE 9000
CMD ["php-fpm"]
