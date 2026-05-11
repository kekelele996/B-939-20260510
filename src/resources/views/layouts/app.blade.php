<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Noto Sans SC', 'system-ui', 'sans-serif'],
                        serif: ['Noto Serif SC', 'Georgia', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&family=Noto+Serif+SC:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans SC', system-ui, sans-serif;
        }
        .prose {
            font-family: 'Noto Serif SC', Georgia, serif;
            line-height: 1.8;
        }
        .prose h1, .prose h2, .prose h3, .prose h4 {
            font-family: 'Noto Sans SC', system-ui, sans-serif;
            font-weight: 700;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- 导航栏 -->
    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900 hover:text-primary-600 transition">
                    {{ config('app.name') }}
                </a>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition">首页</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-primary-600 transition">后台</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 主体内容 -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <!-- 页脚 -->
    <footer class="border-t border-gray-100 mt-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Powered by Laravel.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
