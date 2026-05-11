<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * 数据库种子
 * 初始化基础数据（幂等执行，可重复运行）
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 创建管理员账户（如果不存在）
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@blog.local',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'admin123456')),
            ]);
            $this->command->info('管理员账户创建成功');
        }

        // 创建默认分类（如果不存在）
        if (Category::count() === 0) {
            $categories = [
                ['name' => '技术', 'slug' => 'tech', 'description' => '技术相关文章', 'sort_order' => 1],
                ['name' => '生活', 'slug' => 'life', 'description' => '生活随笔', 'sort_order' => 2],
                ['name' => '读书', 'slug' => 'reading', 'description' => '读书笔记', 'sort_order' => 3],
            ];

            foreach ($categories as $category) {
                Category::create($category);
            }
            $this->command->info('默认分类创建成功');
        }

        // 创建默认标签（如果不存在）
        if (Tag::count() === 0) {
            $tags = [
                ['name' => 'PHP', 'slug' => 'php'],
                ['name' => 'Laravel', 'slug' => 'laravel'],
                ['name' => 'MySQL', 'slug' => 'mysql'],
                ['name' => 'Redis', 'slug' => 'redis'],
                ['name' => 'Docker', 'slug' => 'docker'],
            ];

            foreach ($tags as $tag) {
                Tag::create($tag);
            }
            $this->command->info('默认标签创建成功');
        }
    }
}
