<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * 后台文章管理控制器
 */
class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    /**
     * 文章列表
     */
    public function index(): View
    {
        $articles = $this->articleService->getAllArticles(15);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * 创建文章页面
     */
    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $tags = Tag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * 保存新文章
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = $this->articleService->createArticle(
            $request->validated(),
            auth()->id()
        );

        return redirect()
            ->route('admin.articles.edit', $article)
            ->with('success', '文章创建成功');
    }

    /**
     * 编辑文章页面
     */
    public function edit(Article $article): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $tags = Tag::all();
        $article->load('tags');

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * 更新文章
     */
    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $this->articleService->updateArticle($article, $request->validated());

        return redirect()
            ->route('admin.articles.edit', $article)
            ->with('success', '文章更新成功');
    }

    /**
     * 删除文章
     */
    public function destroy(Article $article): RedirectResponse
    {
        $this->articleService->deleteArticle($article);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '文章删除成功');
    }
}
