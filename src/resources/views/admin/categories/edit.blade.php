@extends('layouts.admin')

@section('title', '编辑分类')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">编辑分类</h1>
    <p class="text-gray-500 mt-1">{{ $category->name }}</p>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">名称 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="分类名称">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">别名 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug', $category->slug) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="URL 别名（英文）">
                @error('slug')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">描述</label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition resize-none"
                          placeholder="分类描述">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">排序</label>
                <input type="number"
                       id="sort_order"
                       name="sort_order"
                       value="{{ old('sort_order', $category->sort_order) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="数字越小越靠前">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="px-6 py-3 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 transition">
                    更新分类
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    取消
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
