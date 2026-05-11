<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;

/**
 * 前台评论控制器
 * 处理访客提交评论
 */
class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    /**
     * 提交评论
     */
    public function store(CommentRequest $request, Article $article): RedirectResponse
    {
        if (!$article->isPublished()) {
            abort(404);
        }

        $this->commentService->createComment(
            $article,
            $request->validated(),
            $request->ip()
        );

        return redirect()
            ->to(route('article.show', $article->slug) . '#comments')
            ->with('success', '评论发布成功');
    }
}
