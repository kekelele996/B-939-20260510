@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- 文章头部 -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>

        <div class="flex items-center gap-4 text-sm text-gray-500">
            @if($article->category)
                <a href="{{ route('home', ['category' => $article->category_id]) }}"
                   class="text-primary-600 hover:underline">
                    {{ $article->category->name }}
                </a>
                <span>·</span>
            @endif
            <time datetime="{{ $article->published_at->toDateString() }}">
                {{ $article->published_at->format('Y年m月d日') }}
            </time>
            <span>·</span>
            <span>{{ $article->view_count }} 次阅读</span>
        </div>

        @if($article->tags->count())
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($article->tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->id]) }}"
                       class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </header>

    <!-- 文章内容 -->
    <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="prose prose-lg max-w-none text-gray-800">
            {!! nl2br(e($article->content)) !!}
        </div>
    </article>

    <!-- 文章信息 -->
    <div class="mt-8 py-6 border-t border-gray-200">
        <p class="text-gray-500 text-sm">
            作者：{{ $article->user->name }}
            · 发布于 {{ $article->published_at->format('Y-m-d H:i') }}
            @if($article->updated_at->gt($article->published_at))
                · 最后更新于 {{ $article->updated_at->format('Y-m-d H:i') }}
            @endif
        </p>
    </div>

    <!-- 相关文章 -->
    @if($relatedArticles->count())
        <div class="mt-8">
            <h3 class="font-bold text-gray-900 mb-4">相关文章</h3>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($relatedArticles as $related)
                    <a href="{{ route('article.show', $related->slug) }}"
                       class="block px-6 py-4 hover:bg-gray-50 transition">
                        <p class="text-gray-900 hover:text-primary-600">{{ $related->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $related->published_at->format('Y-m-d') }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 返回按钮 -->
    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-primary-600 hover:underline">
            ← 返回首页
        </a>
    </div>
</div>
@endsection
