<?php

/**
 * 评论表迁移
 * 文章评论功能
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade')->comment('文章ID');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->text('content')->comment('评论内容');
            $table->ipAddress('ip')->nullable()->comment('IP地址');
            $table->timestamps();

            $table->index('article_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
