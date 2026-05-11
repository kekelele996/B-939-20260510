<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * 评论服务层
 * 处理评论相关的业务逻辑
 */
class CommentService
{
    /**
     * 获取文章的已审核评论（分页）
     */
    public function getArticleComments(Article $article, int $perPage = 10): LengthAwarePaginator
    {
        return $article->approvedComments()->paginate($perPage);
    }

    /**
     * 获取所有评论（管理后台用）
     */
    public function getAllComments(int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        $query = Comment::with('article')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    /**
     * 创建新评论
     */
    public function createComment(Article $article, array $data, Request $request): Comment
    {
        return Comment::create([
            'article_id' => $article->id,
            'guest_name' => $data['guest_name'],
            'guest_email' => $data['guest_email'],
            'content' => $data['content'],
            'status' => config('app.comment_auto_approve', true) ? 'approved' : 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * 删除评论
     */
    public function deleteComment(Comment $comment): bool
    {
        return $comment->delete();
    }

    /**
     * 审核通过评论
     */
    public function approveComment(Comment $comment): void
    {
        $comment->approve();
    }

    /**
     * 标记评论为待审核
     */
    public function markAsPending(Comment $comment): void
    {
        $comment->markAsPending();
    }

    /**
     * 获取待审核评论数量
     */
    public function getPendingCount(): int
    {
        return Comment::pending()->count();
    }

    /**
     * 清除文章评论缓存
     */
    public function clearArticleCommentsCache(Article $article): void
    {
        Cache::forget("article:{$article->id}:comments");
    }
}
