@extends('layouts.admin')

@section('title', '评论管理')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">评论管理</h1>
        <p class="text-gray-500 mt-1">管理所有文章评论</p>
    </div>
</div>

<!-- 状态筛选标签 -->
<div class="flex gap-2 mb-6">
    <a href="{{ route('admin.comments.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition
              {{ !$status ? 'bg-sky-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        全部
    </a>
    <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition
              {{ $status === 'approved' ? 'bg-sky-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        已通过
    </a>
    <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition
              {{ $status === 'pending' ? 'bg-sky-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        待审核
        @if($pendingCount > 0)
            <span class="ml-1 px-2 py-0.5 text-xs bg-red-100 text-red-600 rounded-full">{{ $pendingCount }}</span>
        @endif
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">评论者</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">评论内容</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">所属文章</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">状态</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">时间</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($comments as $comment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $comment->getGravatarUrl(32) }}" alt="{{ e($comment->guest_name) }}"
                                 class="w-8 h-8 rounded-full bg-gray-200">
                            <div>
                                <p class="text-gray-900 font-medium text-sm">{{ e($comment->guest_name) }}</p>
                                <p class="text-gray-500 text-xs">{{ e($comment->guest_email) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-700 text-sm line-clamp-2" title="{{ e($comment->content) }}">
                            {{ e(Str::limit($comment->content, 80)) }}
                        </p>
                        @if($comment->ip_address)
                            <p class="text-gray-400 text-xs mt-1">IP: {{ $comment->ip_address }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($comment->article)
                            <a href="{{ route('article.show', $comment->article->slug) }}" target="_blank"
                               class="text-gray-600 hover:text-sky-600 text-sm">
                                {{ e(Str::limit($comment->article->title, 30)) }}
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $comment->status === 'approved' ? '已通过' : '待审核' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">
                        {{ $comment->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($comment->article)
                                <a href="{{ route('article.show', $comment->article->slug) }}#comments" target="_blank"
                                   class="text-gray-400 hover:text-sky-600" title="查看">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @endif
                            @if($comment->isPending())
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-green-600" title="通过">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.comments.pending', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-yellow-600" title="标记待审核">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline"
                                  onsubmit="return confirm('确定要删除这条评论吗？此操作不可撤销。')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="删除">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        暂无评论
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $comments->links() }}
</div>
@endsection
