<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

/**
 * 评论服务层
 * 处理评论相关的业务逻辑和缓存
 */
class CommentService
{
    /**
     * 创建评论
     */
    public function createComment(Article $article, array $data, string $ip = null): Comment
    {
        $comment = $article->comments()->create([
            'nickname' => $data['nickname'],
            'email' => $data['email'] ?? null,
            'content' => $data['content'],
            'ip' => $ip,
        ]);

        Cache::forget("article:slug:{$article->slug}");

        return $comment;
    }

    /**
     * 删除评论
     */
    public function deleteComment(Comment $comment): bool
    {
        $article = $comment->article;
        $deleted = $comment->delete();

        if ($article) {
            Cache::forget("article:slug:{$article->slug}");
        }

        return $deleted;
    }

    /**
     * 获取评论列表（后台管理用）
     */
    public function getAllComments(int $perPage = 15): LengthAwarePaginator
    {
        return Comment::with('article')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
