<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 文章服务层
 * 处理文章相关的业务逻辑和缓存
 */
class ArticleService
{
    private const CACHE_TTL = 3600; // 缓存1小时

    /**
     * 获取已发布文章列表（分页）
     */
    public function getPublishedArticles(int $perPage = 10, ?int $categoryId = null, ?int $tagId = null): LengthAwarePaginator
    {
        $query = Article::with(['user', 'category', 'tags'])
            ->published()
            ->latest();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($tagId) {
            $query->whereHas('tags', fn($q) => $q->where('tags.id', $tagId));
        }

        return $query->paginate($perPage);
    }

    /**
     * 获取文章详情（带缓存）
     */
    public function getArticleBySlug(string $slug): ?Article
    {
        return Cache::remember(
            "article:slug:{$slug}",
            self::CACHE_TTL,
            fn() => Article::with(['user', 'category', 'tags'])
                ->where('slug', $slug)
                ->published()
                ->first()
        );
    }

    /**
     * 获取文章详情（通过ID，管理后台用）
     */
    public function getArticleById(int $id): ?Article
    {
        return Article::with(['user', 'category', 'tags'])->find($id);
    }

    /**
     * 获取所有文章（管理后台用）
     */
    public function getAllArticles(int $perPage = 15): LengthAwarePaginator
    {
        return Article::with(['user', 'category'])
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * 创建文章
     */
    public function createArticle(array $data, int $userId): Article
    {
        return DB::transaction(function () use ($data, $userId) {
            $article = Article::create([
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? null,
                'title' => $data['title'],
                'slug' => $data['slug'] ?? Str::slug($data['title']) . '-' . Str::random(6),
                'excerpt' => $data['excerpt'] ?? null,
                'content' => $data['content'],
                'cover_image' => $data['cover_image'] ?? null,
                'status' => $data['status'] ?? 'draft',
                'published_at' => ($data['status'] ?? 'draft') === 'published' ? now() : null,
            ]);

            if (!empty($data['tags'])) {
                $article->tags()->sync($data['tags']);
            }

            return $article;
        });
    }

    /**
     * 更新文章
     */
    public function updateArticle(Article $article, array $data): Article
    {
        return DB::transaction(function () use ($article, $data) {
            // 状态变为发布时，设置发布时间
            if (($data['status'] ?? $article->status) === 'published' && !$article->published_at) {
                $data['published_at'] = now();
            }

            $article->update($data);

            if (isset($data['tags'])) {
                $article->tags()->sync($data['tags']);
            }

            // 清除缓存
            $this->clearArticleCache($article);

            return $article->fresh(['user', 'category', 'tags']);
        });
    }

    /**
     * 删除文章
     */
    public function deleteArticle(Article $article): bool
    {
        $this->clearArticleCache($article);
        return $article->delete();
    }

    /**
     * 增加文章浏览次数
     */
    public function incrementViewCount(Article $article): void
    {
        $article->incrementViewCount();
        // 更新缓存中的浏览次数
        Cache::forget("article:slug:{$article->slug}");
    }

    /**
     * 清除文章缓存
     */
    private function clearArticleCache(Article $article): void
    {
        Cache::forget("article:slug:{$article->slug}");
    }
}
