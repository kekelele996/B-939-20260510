<?php

/**
 * 文章表迁移
 * 博客文章主表
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('作者');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->comment('分类');
            $table->string('title', 200)->comment('标题');
            $table->string('slug', 200)->unique()->comment('URL 别名');
            $table->text('excerpt')->nullable()->comment('摘要');
            $table->longText('content')->comment('正文内容');
            $table->string('cover_image')->nullable()->comment('封面图');
            $table->enum('status', ['draft', 'published'])->default('draft')->comment('状态');
            $table->integer('view_count')->unsigned()->default(0)->comment('浏览次数');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
