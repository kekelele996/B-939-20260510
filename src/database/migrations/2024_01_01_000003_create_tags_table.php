<?php

/**
 * 标签表迁移
 * 文章标签管理
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->comment('标签名称');
            $table->string('slug', 30)->unique()->comment('URL 别名');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
