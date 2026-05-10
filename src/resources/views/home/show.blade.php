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
    <div id="comments" class="mt-8">
        <h3 class="font-bold text-gray-900 mb-4">评论 ({{ $article->comments->count() }})</h3>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($article->comments->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100 mb-6">
                @foreach($article->comments as $comment)
                    <div class="px-6 py-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-medium text-gray-900">{{ $comment->nickname }}</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm mb-6">暂无评论，来抢沙发吧！</p>
        @endif

        <!-- 评论表单 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-medium text-gray-900 mb-4">发表评论</h4>
            <form action="{{ route('comment.store', $article) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nickname" class="block text-sm text-gray-600 mb-1">昵称 <span class="text-red-500">*</span></label>
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nickname') border-red-500 @enderror"
                               placeholder="你的昵称" required>
                        @error('nickname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm text-gray-600 mb-1">邮箱</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="选填，不会公开">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm text-gray-600 mb-1">评论内容 <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('content') border-red-500 @enderror"
                              placeholder="说点什么..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition">
                    提交评论
                </button>
            </form>
        </div>
    </div>

    <!-- 返回按钮 -->
    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-primary-600 hover:underline">
            ← 返回首页
        </a>
    </div>
</div>
@endsection
