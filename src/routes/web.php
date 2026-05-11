<?php

/**
 * Web 路由配置
 */

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 前台路由
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}', [HomeController::class, 'show'])->name('article.show');
Route::post('/article/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');

/*
|--------------------------------------------------------------------------
| 后台路由
|--------------------------------------------------------------------------
*/

// 登录相关（无需认证）
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// 后台管理（需认证）
Route::prefix('admin')->middleware('auth.admin')->group(function () {
    // 仪表板
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 文章管理
    Route::resource('articles', ArticleController::class)->names([
        'index' => 'admin.articles.index',
        'create' => 'admin.articles.create',
        'store' => 'admin.articles.store',
        'edit' => 'admin.articles.edit',
        'update' => 'admin.articles.update',
        'destroy' => 'admin.articles.destroy',
    ]);

    // 分类管理
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // 标签管理
    Route::resource('tags', TagController::class)->names([
        'index' => 'admin.tags.index',
        'create' => 'admin.tags.create',
        'store' => 'admin.tags.store',
        'edit' => 'admin.tags.edit',
        'update' => 'admin.tags.update',
        'destroy' => 'admin.tags.destroy',
    ]);

    // 评论管理
    Route::prefix('comments')->name('admin.comments.')->group(function () {
        Route::get('/', [AdminCommentController::class, 'index'])->name('index');
        Route::delete('/{comment}', [AdminCommentController::class, 'destroy'])->name('destroy');
        Route::post('/{comment}/approve', [AdminCommentController::class, 'approve'])->name('approve');
        Route::post('/{comment}/pending', [AdminCommentController::class, 'pending'])->name('pending');
    });
});
