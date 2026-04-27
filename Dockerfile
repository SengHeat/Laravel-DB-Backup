FROM kimleang/laravel-runtime:latest

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    postgresql-client \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*
