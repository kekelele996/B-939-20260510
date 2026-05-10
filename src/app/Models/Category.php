<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 分类模型
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
    ];

    /**
     * 分类下的文章
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * 获取已发布文章数量
     */
    public function getPublishedArticlesCountAttribute(): int
    {
        return $this->articles()->where('status', 'published')->count();
    }
}
