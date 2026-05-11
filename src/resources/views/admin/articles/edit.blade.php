@extends('layouts.admin')

@section('title', '编辑文章')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">编辑文章</h1>
    <p class="text-gray-500 mt-1">{{ $article->title }}</p>
</div>

<form action="{{ route('admin.articles.update', $article) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 主内容区 -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 标题 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">标题 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $article->title) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="输入文章标题">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL 别名 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL 别名</label>
                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug', $article->slug) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                @error('slug')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 摘要 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">摘要</label>
                <textarea id="excerpt"
                          name="excerpt"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition resize-none"
                          placeholder="文章摘要，显示在列表页">{{ old('excerpt', $article->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 内容 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">内容 <span class="text-red-500">*</span></label>
                <textarea id="content"
                          name="content"
                          rows="20"
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition font-mono text-sm"
                          placeholder="输入文章内容">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 侧边栏 -->
        <div class="space-y-6">
            <!-- 发布设置 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">发布设置</h3>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">状态</label>
                    <select id="status"
                            name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>草稿</option>
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>发布</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-sky-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 transition">
                    更新文章
                </button>

                @if($article->status === 'published')
                    <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                       class="block w-full text-center mt-3 py-3 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        查看文章
                    </a>
                @endif
            </div>

            <!-- 分类 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">分类</h3>
                <select id="category_id"
                        name="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                    <option value="">-- 选择分类 --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 标签 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">标签</h3>
                @php
                    $selectedTags = old('tags', $article->tags->pluck('id')->toArray());
                @endphp
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($tags as $tag)
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="tags[]"
                                   value="{{ $tag->id }}"
                                   {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <span class="ml-2 text-gray-700">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 封面图 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">封面图</h3>
                <input type="text"
                       id="cover_image"
                       name="cover_image"
                       value="{{ old('cover_image', $article->cover_image) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="图片 URL">
            </div>

            <!-- 文章信息 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-medium text-gray-900 mb-4">文章信息</h3>
                <dl class="text-sm space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">浏览次数</dt>
                        <dd class="text-gray-900">{{ $article->view_count }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">创建时间</dt>
                        <dd class="text-gray-900">{{ $article->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                    @if($article->published_at)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">发布时间</dt>
                            <dd class="text-gray-900">{{ $article->published_at->format('Y-m-d H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</form>
@endsection
