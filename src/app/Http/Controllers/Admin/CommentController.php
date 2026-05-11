<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');

        $comments = $this->commentService->getAllComments($status, 20);
        $pendingCount = $this->commentService->getPendingCount();
        $approvedCount = $this->commentService->getApprovedCount();
        $totalCount = $this->commentService->getTotalCount();

        return view('admin.comments.index', compact(
            'comments',
            'status',
            'pendingCount',
            'approvedCount',
            'totalCount'
        ));
    }

    public function updateStatus(Comment $comment, string $status): RedirectResponse
    {
        try {
            $this->commentService->updateStatus($comment, $status);
            $statusText = $this->commentService->getStatusText($status);

            return redirect()
                ->route('admin.comments.index')
                ->with('success', "评论状态已更新为：{$statusText}");
        } catch (\InvalidArgumentException) {
            return redirect()
                ->route('admin.comments.index')
                ->with('error', '无效的状态');
        }
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->commentService->deleteComment($comment);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', '评论已删除');
    }
}
