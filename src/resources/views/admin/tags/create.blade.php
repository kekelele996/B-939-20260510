@extends('layouts.admin')

@section('title', '新建标签')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">新建标签</h1>
    <p class="text-gray-500 mt-1">创建一个新标签</p>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.tags.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">名称 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="标签名称">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">别名 <span class="text-red-500">*</span></label>
                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug') }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition"
                       placeholder="URL 别名（英文）">
                @error('slug')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="px-6 py-3 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 transition">
                    保存标签
                </button>
                <a href="{{ route('admin.tags.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    取消
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
