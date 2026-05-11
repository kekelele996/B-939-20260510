<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 评论模型
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'nickname',
        'email',
        'content',
        'ip',
    ];

    /**
     * 所属文章
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
