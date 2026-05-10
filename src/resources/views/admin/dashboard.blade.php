@extends('layouts.admin')

@section('title', '仪表板')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">仪表板</h1>
    <p class="text-gray-500 mt-1">欢迎回来，{{ auth()->user()->name }}</p>
</div>

<!-- 统计卡片 -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">文章总数</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['articles_count'] }}</p>
            </div>
            <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm">
            <span class="text-green-600">{{ $stats['published_count'] }} 已发布</span>
            <span class="text-gray-400 mx-2">·</span>
            <span class="text-yellow-600">{{ $stats['draft_count'] }} 草稿</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">分类数量</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['categories_count'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            {{ $stats['tags_count'] }} 个标签
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">总浏览量</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- 快捷操作 -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-900 mb-4">快捷操作</h2>
    <div class="flex gap-4">
        <a href="{{ route('admin.articles.create') }}"
           class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            写新文章
        </a>
        <a href="{{ route('home') }}" target="_blank"
           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            查看前台
        </a>
    </div>
</div>

<!-- 最近文章 -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-900">最近文章</h2>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($recentArticles as $article)
            <div class="p-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-gray-900 hover:text-sky-600 font-medium">
                        {{ $article->title }}
                    </a>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $article->category?->name ?? '未分类' }}
                        · {{ $article->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>
                <span class="px-2 py-1 text-xs rounded
                    {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $article->status === 'published' ? '已发布' : '草稿' }}
                </span>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                暂无文章
            </div>
        @endforelse
    </div>
</div>
@endsection
