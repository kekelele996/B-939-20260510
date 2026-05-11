<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * 后台评论管理控制器
 */
class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    /**
     * 评论列表
     */
    public function index(): View
    {
        $comments = $this->commentService->getAllComments(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * 删除评论
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->commentService->deleteComment($comment);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', '评论已删除');
    }
}
