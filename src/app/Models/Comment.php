<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'guest_name',
        'guest_email',
        'content',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 评论所属的文章
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * 已审核通过的评论
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * 待审核的评论
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * 按时间倒序
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * 是否为已审核状态
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * 是否为待审核状态
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * 审核通过
     */
    public function approve(): void
    {
        $this->update(['status' => 'approved']);
    }

    /**
     * 标记为待审核
     */
    public function markAsPending(): void
    {
        $this->update(['status' => 'pending']);
    }

    /**
     * 获取评论者头像（使用 Gravatar）
     */
    public function getGravatarUrl(int $size = 40): string
    {
        $hash = md5(strtolower(trim($this->guest_email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }
}
