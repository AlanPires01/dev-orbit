# ==========================================
# ESTÁGIO 1: Build das Dependências (Composer)
# ==========================================
FROM composer:2.6 AS vendor-build

WORKDIR /app

# Copia apenas os arquivos de dependências para otimizar o cache de camadas
COPY composer.json composer.lock ./

# Instala as dependências de produção sem scripts interativos
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-ansi

# Copia o restante do código fonte do projeto
COPY . .

# Gera o autoloader otimizado para produção
RUN composer dump-autoload --no-dev --optimize


# ==========================================
# ESTÁGIO 2: Imagem Final de Produção (Runtime)
# ==========================================
FROM php:8.2-fpm-alpine AS production

# Define variáveis de ambiente essenciais
ENV TZ=America/Sao_Paulo \
    APP_ENV=production \
    APP_DEBUG=false

# Instala dependências do sistema e extensões PHP necessárias para o Laravel
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    oniguruma-dev

# Utiliza o instalador oficial de extensões PHP para Alpine
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd opcache

WORKDIR /var/www/html

# Copia o código já limpo e com as dependências do Estágio 1
COPY --from=vendor-build /app /var/www/html

# Ajusta permissões corretas para o armazenamento e cache do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Segurança: Altera para o usuário não-root (www-data) na execução final
USER www-data

EXPOSE 9000

CMD ["php-fpm"] 