@extends('layouts.admin')

@section('title', '评论管理')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">评论管理</h1>
        <p class="text-gray-500 mt-1">管理文章评论，删除不合适的内容</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">评论人</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">内容</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">所属文章</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">时间</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($comments as $comment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $comment->nickname }}</p>
                        @if($comment->email)
                            <p class="text-xs text-gray-400">{{ $comment->email }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-700 text-sm max-w-xs truncate">{{ $comment->content }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($comment->article)
                            <a href="{{ route('article.show', $comment->article->slug) }}"
                               class="text-sky-600 hover:underline text-sm" target="_blank">
                                {{ Str::limit($comment->article->title, 30) }}
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">已删除</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">
                        {{ $comment->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline"
                              onsubmit="return confirm('确定要删除这条评论吗？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600" title="删除">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
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
