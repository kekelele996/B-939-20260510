<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $comments = $this->commentService->getAllComments(15, $status);
        $pendingCount = $this->commentService->getPendingCount();

        return view('admin.comments.index', compact('comments', 'status', 'pendingCount'));
    }

    /**
     * 删除评论
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->commentService->deleteComment($comment);

        return redirect()
            ->back()
            ->with('success', '评论删除成功');
    }

    /**
     * 审核通过评论
     */
    public function approve(Comment $comment): RedirectResponse
    {
        $this->commentService->approveComment($comment);

        return redirect()
            ->back()
            ->with('success', '评论已通过审核');
    }

    /**
     * 标记为待审核
     */
    public function pending(Comment $comment): RedirectResponse
    {
        $this->commentService->markAsPending($comment);

        return redirect()
            ->back()
            ->with('success', '评论已标记为待审核');
    }
}
