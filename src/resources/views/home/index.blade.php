@extends('layouts.app')

@section('title', '首页')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <!-- 文章列表 -->
    <div class="flex-1">
        @if($categoryId || $tagId)
            <div class="mb-6 pb-4 border-b border-gray-200">
                <p class="text-gray-600">
                    @if($categoryId)
                        分类：<span class="font-medium text-gray-900">{{ $categories->firstWhere('id', $categoryId)?->name }}</span>
                    @endif
                    @if($tagId)
                        标签：<span class="font-medium text-gray-900">{{ $tags->firstWhere('id', $tagId)?->name }}</span>
                    @endif
                    <a href="{{ route('home') }}" class="ml-4 text-sm text-primary-600 hover:underline">清除筛选</a>
                </p>
            </div>
        @endif

        @forelse($articles as $article)
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
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

                <h2 class="text-xl font-bold mb-3">
                    <a href="{{ route('article.show', $article->slug) }}"
                       class="text-gray-900 hover:text-primary-600 transition">
                        {{ $article->title }}
                    </a>
                </h2>

                @if($article->excerpt)
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $article->excerpt }}</p>
                @endif

                @if($article->tags->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('home', ['tag' => $tag->id]) }}"
                               class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </article>
        @empty
            <div class="text-center py-16">
                <p class="text-gray-500">暂无文章</p>
            </div>
        @endforelse

        <!-- 分页 -->
        <div class="mt-8">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>

    <!-- 侧边栏 -->
    <aside class="lg:w-72 space-y-6">
        <!-- 分类列表 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">分类</h3>
            <ul class="space-y-2">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route('home', ['category' => $category->id]) }}"
                           class="flex justify-between text-gray-600 hover:text-primary-600 transition
                                  {{ $categoryId == $category->id ? 'text-primary-600 font-medium' : '' }}">
                            <span>{{ $category->name }}</span>
                            <span class="text-gray-400">{{ $category->published_articles_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- 标签云 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">标签</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->id]) }}"
                       class="text-sm px-3 py-1 rounded-full transition
                              {{ $tagId == $tag->id
                                  ? 'bg-primary-500 text-white'
                                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>
@endsection
