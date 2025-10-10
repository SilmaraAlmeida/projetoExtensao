# Usa imagem oficial PHP com Apache
FROM php:8.2-apache

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        unzip \
        git \
        libzip-dev \
    && docker-php-ext-install pdo_mysql mysqli zip \
    && rm -rf /var/lib/apt/lists/*

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Copia a configuração do Apache
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copia Composer oficial via multi-stage build
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia apenas os arquivos do Composer primeiro (melhor cache)
COPY composer.json composer.lock ./

# Instala dependências PHP (sem scripts ou autoload ainda)
RUN composer install --no-interaction --no-scripts --no-autoloader

# Copia o restante do código da aplicação
COPY . .

# Gera autoload otimizado
RUN composer dump-autoload --optimize

# Ajusta permissões para o usuário www-data
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expõe a porta 80
EXPOSE 80

# Define o comando de inicialização
CMD ["apache2-foreground"]
