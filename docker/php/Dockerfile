# PHP 8.2 FPM 镜像
# 包含 Laravel 运行所需的全部扩展

FROM php:8.2-fpm-alpine

# 安装系统依赖
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    icu-dev \
    linux-headers \
    netcat-openbsd \
    $PHPIZE_DEPS

# 安装 PHP 扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        opcache

# 安装 Redis 扩展
RUN pecl install redis && docker-php-ext-enable redis

# 安装 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP 配置优化
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# 自定义 PHP 配置
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# 复制启动脚本
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 设置工作目录
WORKDIR /var/www/html

# 创建用户并设置权限
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www:www /var/www/html

EXPOSE 9000

# 使用 root 启动以便初始化时有权限，entrypoint 内部会处理
ENTRYPOINT ["entrypoint.sh"]
