@extends('layouts.admin')

@section('title', '评论管理')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">评论管理</h1>
</div>

<div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.comments.index') }}"
           class="px-4 py-2 rounded-lg transition
                  {{ is_null($status) ? 'bg-sky-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            全部 ({{ $totalCount }})
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
           class="px-4 py-2 rounded-lg transition
                  {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            待审核 ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
           class="px-4 py-2 rounded-lg transition
                  {{ $status === 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            已通过 ({{ $approvedCount }})
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($comments->count())
        <div class="divide-y divide-gray-100">
            @foreach($comments as $comment)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-semibold text-gray-900">{{ $comment->author_name }}</span>
                                @if($comment->author_email)
                                    <span class="text-sm text-gray-500">{{ $comment->author_email }}</span>
                                @endif
                                <span class="text-xs px-2 py-1 rounded
                                    {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' :
                                       ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $comment->status === 'approved' ? '已通过' :
                                       ($comment->status === 'pending' ? '待审核' : '已拒绝') }}
                                </span>
                            </div>

                            <p class="text-gray-700 mb-3">{{ $comment->content }}</p>

                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>评论于：{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                @if($comment->article)
                                    <a href="{{ route('article.show', $comment->article->slug) }}"
                                       target="_blank"
                                       class="text-sky-600 hover:underline">
                                        《{{ $comment->article->title }}》
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            @if($comment->status !== 'approved')
                                <form action="{{ route('admin.comments.update-status', [$comment, 'approved']) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
                                        通过
                                    </button>
                                </form>
                            @endif

                            @if($comment->status !== 'pending')
                                <form action="{{ route('admin.comments.update-status', [$comment, 'pending']) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                        待审核
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.comments.destroy', $comment) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('确定要删除这条评论吗？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                                    删除
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($comments->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $comments->links() }}
            </div>
        @endif
    @else
        <div class="p-12 text-center text-gray-500">
            <p class="text-lg">暂无评论</p>
        </div>
    @endif
</div>
@endsection
