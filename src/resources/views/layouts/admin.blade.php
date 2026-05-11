<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - 后台管理</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Noto Sans SC', system-ui, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- 侧边栏 -->
        <aside class="w-64 bg-gray-900 min-h-screen fixed">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">
                    {{ config('app.name') }}
                </a>
                <p class="text-gray-400 text-xs mt-1">后台管理</p>
            </div>

            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white border-r-4 border-sky-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    仪表板
                </a>

                <a href="{{ route('admin.articles.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition
                          {{ request()->routeIs('admin.articles.*') ? 'bg-gray-800 text-white border-r-4 border-sky-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    文章管理
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition
                          {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white border-r-4 border-sky-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    分类管理
                </a>

                <a href="{{ route('admin.tags.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition
                          {{ request()->routeIs('admin.tags.*') ? 'bg-gray-800 text-white border-r-4 border-sky-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    标签管理
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-6 border-t border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-gray-400 text-xs">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition" title="退出">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- 主内容区 -->
        <main class="flex-1 ml-64 p-8">
            <!-- 消息提示 -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
