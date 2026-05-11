#!/bin/sh

# PHP 容器启动入口脚本
# 自动完成项目初始化

set -e

cd /var/www/html

# 等待 MySQL 就绪
echo "等待 MySQL 启动..."
max_tries=30
counter=0
while ! nc -z mysql 3306 2>/dev/null; do
    counter=$((counter + 1))
    if [ $counter -gt $max_tries ]; then
        echo "MySQL 连接超时，继续启动..."
        break
    fi
    echo "等待 MySQL... ($counter/$max_tries)"
    sleep 2
done

# 确保 .env 文件存在
if [ ! -f ".env" ]; then
    echo "创建 .env 文件..."
    cp env.example .env
fi

# 首次启动：安装依赖
if [ ! -f "vendor/autoload.php" ]; then
    echo "=== 首次启动，正在安装依赖 ==="
    composer install --no-interaction --optimize-autoloader
    echo "=== 依赖安装完成 ==="
fi

# 检查并生成 APP_KEY（每次启动都检查）
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
    echo "生成应用密钥..."
    php artisan key:generate --force
fi

# 等待 MySQL 完全就绪
sleep 3

# 运行数据库迁移
echo "检查数据库迁移..."
if php artisan migrate --force 2>/dev/null; then
    echo "数据库迁移完成"
else
    echo "数据库迁移失败或已是最新"
fi

# 填充初始数据（幂等执行）
echo "检查初始数据..."
php artisan db:seed --force 2>&1 | grep -v "Nothing to seed" || true

# 创建必要的目录
mkdir -p storage/app storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# 设置目录所有者和权限
chown -R www:www storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs storage/framework

echo "=== 项目启动完成 ==="
echo "前台: http://localhost"
echo "后台: http://localhost/admin"
echo "账号: admin@blog.local / admin123456"
echo "================================"

# 启动 PHP-FPM
exec php-fpm
