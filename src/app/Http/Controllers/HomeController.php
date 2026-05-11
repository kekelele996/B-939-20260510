<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 前台首页控制器
 * 处理文章列表和详情展示
 */
class HomeController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    /**
     * 文章列表页
     */
    public function index(Request $request): View
    {
        $categoryId = $request->query('category');
        $tagId = $request->query('tag');

        $articles = $this->articleService->getPublishedArticles(
            perPage: 10,
            categoryId: $categoryId,
            tagId: $tagId
        );

        $categories = Category::orderBy('sort_order')->get();
        $tags = Tag::withCount(['articles' => fn($q) => $q->published()])->get();

        return view('home.index', compact('articles', 'categories', 'tags', 'categoryId', 'tagId'));
    }

    /**
     * 文章详情页
     */
    public function show(string $slug): View
    {
        $article = $this->articleService->getArticleBySlug($slug);

        if (!$article) {
            abort(404);
        }

        // 增加浏览次数
        $this->articleService->incrementViewCount($article);

        // 获取相关文章
        $relatedArticles = $article->category
            ? $article->category->articles()
                ->published()
                ->where('id', '!=', $article->id)
                ->latest()
                ->limit(5)
                ->get()
            : collect();

        return view('home.show', compact('article', 'relatedArticles'));
    }
}
