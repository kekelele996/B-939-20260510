<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 后台分类管理控制器
 */
class CategoryController extends Controller
{
    /**
     * 分类列表
     */
    public function index(): View
    {
        $categories = Category::withCount('articles')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * 创建分类页面
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * 保存新分类
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', '分类创建成功');
    }

    /**
     * 编辑分类页面
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * 更新分类
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50', 'unique:categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', '分类更新成功');
    }

    /**
     * 删除分类
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->articles()->exists()) {
            return back()->with('error', '该分类下存在文章，无法删除');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', '分类删除成功');
    }
}
