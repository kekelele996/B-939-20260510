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

    <!-- 评论区 -->
    <div class="mt-12">
        <h3 class="text-xl font-bold text-gray-900 mb-6">
            评论 ({{ $comments->count() }})
        </h3>

        @if(session('comment_success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('comment_success') }}
            </div>
        @endif

        <!-- 评论表单 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h4 class="font-semibold text-gray-900 mb-4">发表评论</h4>
            <form action="{{ route('article.comment.store', $article->slug) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            昵称 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="author_name"
                               required
                               maxlength="50"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition"
                               placeholder="请输入您的昵称">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            邮箱
                        </label>
                        <input type="email"
                               name="author_email"
                               maxlength="100"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition"
                               placeholder="选填，不会公开">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        评论内容 <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content"
                              required
                              maxlength="2000"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition resize-none"
                              placeholder="请输入评论内容..."></textarea>
                </div>
                <button type="submit"
                        class="px-6 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition font-medium">
                    提交评论
                </button>
            </form>
        </div>

        <!-- 评论列表 -->
        @if($comments->count())
            <div class="space-y-6">
                @foreach($comments as $comment)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center font-semibold">
                                    {{ mb_substr($comment->author_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $comment->author_name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $comment->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="text-gray-700 pl-13">
                            {{ $comment->content }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <p class="text-gray-500">暂无评论，快来发表第一条评论吧！</p>
            </div>
        @endif
    </div>

    <!-- 返回按钮 -->
    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-sky-600 hover:underline">
            ← 返回首页
        </a>
    </div>
</div>
@endsection
