<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function getAllComments(?string $status = null, int $perPage = 20): LengthAwarePaginator
    {
        return Comment::with('article')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function getPendingCount(): int
    {
        return Comment::pending()->count();
    }

    public function getApprovedCount(): int
    {
        return Comment::approved()->count();
    }

    public function getTotalCount(): int
    {
        return Comment::count();
    }

    public function getApprovedCommentsByArticle(Article $article)
    {
        return $article->approvedComments()->get();
    }

    public function createComment(Article $article, array $data, ?string $ipAddress = null): Comment
    {
        return DB::transaction(function () use ($article, $data, $ipAddress) {
            $comment = new Comment([
                'author_name' => $data['author_name'],
                'author_email' => $data['author_email'] ?? null,
                'content' => $data['content'],
                'status' => 'pending',
                'ip_address' => $ipAddress,
            ]);

            $article->comments()->save($comment);

            return $comment;
        });
    }

    public function updateStatus(Comment $comment, string $status): Comment
    {
        if (!in_array($status, ['approved', 'pending', 'rejected'])) {
            throw new \InvalidArgumentException('无效的评论状态');
        }

        $comment->update(['status' => $status]);

        return $comment->fresh();
    }

    public function deleteComment(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function getStatusText(string $status): string
    {
        return match ($status) {
            'approved' => '已通过',
            'pending' => '待审核',
            'rejected' => '已拒绝',
            default => '未知',
        };
    }
}
