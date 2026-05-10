# Private Blog System

基于 Laravel 10 + MySQL 8 + Redis 的私人博客系统，使用 Docker Compose 一键部署。

## 技术栈

- PHP 8.2 + Laravel 10
- MySQL 8.0
- Redis 7
- Nginx 1.25

## 快速开始

```bash
docker compose up -d
```

首次启动会自动完成以下初始化操作：
- 安装 Composer 依赖
- 生成应用密钥
- 执行数据库迁移
- 填充初始数据

等待约 1-2 分钟后即可访问。

## 访问地址

| 地址 | 说明 |
|------|------|
| 启动完成后等待30秒左右初始化再访问
| http://localhost | 博客前台 |
| http://localhost/admin | 后台管理 |

## 默认管理员账号

- **邮箱**: `admin@blog.local`
- **密码**: `admin123456`

> ⚠️ 首次登录后请及时修改密码

## 查看启动日志

```bash
# 查看 PHP 容器日志（初始化进度）
docker compose logs -f php
```

## 目录结构

```
blog/
├── docker-compose.yml          # Docker 编排配置
├── docker/
│   ├── nginx/
│   │   └── default.conf        # Nginx 配置
│   ├── php/
│   │   ├── Dockerfile          # PHP 镜像构建
│   │   ├── entrypoint.sh       # 自动初始化脚本
│   │   └── php.ini             # PHP 配置
│   └── mysql/
│       └── init/               # MySQL 初始化脚本目录
├── src/                        # Laravel 项目源码
│   ├── app/
│   │   ├── Http/Controllers/   # 控制器
│   │   ├── Models/             # 数据模型
│   │   └── Services/           # 业务服务层
│   ├── config/                 # 配置文件
│   ├── database/migrations/    # 数据库迁移
│   ├── resources/views/        # 视图模板
│   └── routes/                 # 路由定义
└── README.md
```

## 功能说明

### 前台功能

- 文章列表（支持分类、标签筛选）
- 文章详情页
- 分类侧边栏
- 标签云

### 后台功能

- 管理员登录/登出
- 文章管理（增删改查）
- 分类管理
- 标签管理
- 仪表板统计

### 缓存策略

文章详情使用 Redis 缓存，默认缓存时间 1 小时。缓存在以下情况自动清除：

- 文章更新时
- 文章删除时

## 数据库设计

### users 表（管理员）

| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | varchar(50) | 用户名 |
| email | varchar(100) | 邮箱（唯一） |
| password | varchar(255) | 密码 |
| created_at | timestamp | 创建时间 |
| updated_at | timestamp | 更新时间 |

### categories 表（分类）

| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | varchar(50) | 分类名称 |
| slug | varchar(50) | URL 别名 |
| description | text | 分类描述 |
| sort_order | int | 排序值 |

### tags 表（标签）

| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | varchar(30) | 标签名称 |
| slug | varchar(30) | URL 别名 |

### articles 表（文章）

| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| user_id | bigint | 作者 ID |
| category_id | bigint | 分类 ID |
| title | varchar(200) | 标题 |
| slug | varchar(200) | URL 别名 |
| excerpt | text | 摘要 |
| content | longtext | 正文内容 |
| cover_image | varchar(255) | 封面图 URL |
| status | enum | 状态（draft/published） |
| view_count | int | 浏览次数 |
| published_at | timestamp | 发布时间 |

### article_tag 表（文章-标签关联）

| 字段 | 类型 | 说明 |
|------|------|------|
| article_id | bigint | 文章 ID |
| tag_id | bigint | 标签 ID |

## 生产部署

### 1. 修改环境变量

编辑 `src/env.example`（会在首次启动时自动复制为 `.env`）：

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. 修改数据库密码

编辑 `docker-compose.yml` 中的数据库配置：

```yaml
mysql:
  environment:
    MYSQL_ROOT_PASSWORD: your_secure_root_password
    MYSQL_PASSWORD: your_secure_password
```

同时修改 `src/env.example`：

```bash
DB_PASSWORD=your_secure_password
```

### 3. 启动服务

```bash
docker compose up -d
```

## 常用命令

```bash
# 启动服务
docker compose up -d

# 停止服务
docker compose down

# 查看日志
docker compose logs -f php

# 进入 PHP 容器
docker exec -it blog_php sh

# 清除缓存
docker exec -it blog_php sh -c "cd /var/www/html && php artisan cache:clear"

# 重新生成配置缓存
docker exec -it blog_php sh -c "cd /var/www/html && php artisan config:cache"

# 完全重置（删除所有数据）
docker compose down -v
docker compose up -d
```

## License

MIT
