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

    <!-- 评论区域 -->
    <div id="comments" class="mt-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">
            评论 ({{ $comments->total() }})
        </h3>

        <!-- 评论成功提示 -->
        @if(session('comment_success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('comment_success') }}
            </div>
        @endif

        <!-- 发表评论表单 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h4 class="font-medium text-gray-900 mb-4">发表评论</h4>
            <form action="{{ route('comments.store', $article->slug) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">昵称</label>
                        <input type="text" name="guest_name" id="guest_name" required maxlength="50"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('guest_name') border-red-500 @enderror"
                               value="{{ old('guest_name') }}" placeholder="请输入您的昵称">
                        @error('guest_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-1">邮箱</label>
                        <input type="email" name="guest_email" id="guest_email" required maxlength="100"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('guest_email') border-red-500 @enderror"
                               value="{{ old('guest_email') }}" placeholder="请输入您的邮箱（不会公开）">
                        @error('guest_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">评论内容</label>
                    <textarea name="content" id="content" rows="4" required maxlength="2000"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent resize-none @error('content') border-red-500 @enderror"
                              placeholder="请输入您的评论...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    发表评论
                </button>
            </form>
        </div>

        <!-- 评论列表 -->
        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-start gap-4">
                        <img src="{{ $comment->getGravatarUrl(48) }}" alt="{{ e($comment->guest_name) }}"
                             class="w-12 h-12 rounded-full bg-gray-200 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-gray-900">{{ e($comment->guest_name) }}</span>
                                <span class="text-xs text-gray-500">
                                    {{ $comment->created_at->format('Y-m-d H:i') }}
                                </span>
                            </div>
                            <div class="text-gray-700 whitespace-pre-wrap">{{ e($comment->content) }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-500">
                    暂无评论，来发表第一条评论吧！
                </div>
            @endforelse
        </div>

        <!-- 分页 -->
        @if($comments->hasPages())
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

    <!-- 返回按钮 -->
    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-primary-600 hover:underline">
            ← 返回首页
        </a>
    </div>
</div>
@endsection
