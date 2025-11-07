# Dockerfile para app PHP + Apache
FROM php:8.2-apache

# Instala extensões necessárias
RUN apt-get update \
    && apt-get install -y libpq-dev git unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Habilita mod_rewrite (opcional, para URLs amigáveis)
RUN a2enmod rewrite

# Copia o código para o container
COPY . /var/www/html/

# Permissões (ajuste se necessário)
RUN chown -R www-data:www-data /var/www/html

# Expor porta padrão do Apache
EXPOSE 84

# Arquivo de ambiente (opcional, para debug)
# ENV ENVIRONMENT=development
