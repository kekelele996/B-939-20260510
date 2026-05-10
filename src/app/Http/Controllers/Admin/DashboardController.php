<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;

/**
 * 后台仪表板控制器
 */
class DashboardController extends Controller
{
    /**
     * 仪表板首页
     */
    public function index(): View
    {
        $stats = [
            'articles_count' => Article::count(),
            'published_count' => Article::published()->count(),
            'draft_count' => Article::draft()->count(),
            'categories_count' => Category::count(),
            'tags_count' => Tag::count(),
            'total_views' => Article::sum('view_count'),
        ];

        $recentArticles = Article::with('category')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}
