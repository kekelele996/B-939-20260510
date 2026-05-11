@extends('layouts.admin')

@section('title', '文章管理')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">文章管理</h1>
        <p class="text-gray-500 mt-1">管理所有文章</p>
    </div>
    <a href="{{ route('admin.articles.create') }}"
       class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        新建文章
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">标题</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">分类</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">状态</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">浏览</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">创建时间</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($articles as $article)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-gray-900 hover:text-sky-600 font-medium">
                            {{ Str::limit($article->title, 40) }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $article->category?->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $article->status === 'published' ? '已发布' : '草稿' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $article->view_count }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">
                        {{ $article->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($article->status === 'published')
                                <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                                   class="text-gray-400 hover:text-sky-600" title="查看">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @endif
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               class="text-gray-400 hover:text-sky-600" title="编辑">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline"
                                  onsubmit="return confirm('确定要删除这篇文章吗？')">
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
                        暂无文章
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $articles->links() }}
</div>
@endsection
