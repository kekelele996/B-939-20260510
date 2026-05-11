<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * 前台评论控制器
 */
class CommentController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly CommentService $commentService
    ) {}

    /**
     * 发表评论
     */
    public function store(CommentRequest $request, string $slug): RedirectResponse
    {
        $article = $this->articleService->getArticleBySlug($slug);

        if (!$article || !$article->isPublished()) {
            abort(404);
        }

        $this->commentService->createComment($article, $request->validated(), $request);
        $this->commentService->clearArticleCommentsCache($article);

        return redirect()
            ->route('article.show', $slug)
            ->with('comment_success', '评论发表成功！')
            ->withFragment('comments');
    }
}
