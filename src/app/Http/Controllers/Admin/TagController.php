<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 后台标签管理控制器
 */
class TagController extends Controller
{
    /**
     * 标签列表
     */
    public function index(): View
    {
        $tags = Tag::withCount('articles')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * 创建标签页面
     */
    public function create(): View
    {
        return view('admin.tags.create');
    }

    /**
     * 保存新标签
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'slug' => ['required', 'string', 'max:30', 'unique:tags'],
        ]);

        Tag::create($data);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', '标签创建成功');
    }

    /**
     * 编辑标签页面
     */
    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * 更新标签
     */
    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'slug' => ['required', 'string', 'max:30', 'unique:tags,slug,' . $tag->id],
        ]);

        $tag->update($data);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', '标签更新成功');
    }

    /**
     * 删除标签
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->articles()->detach();
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', '标签删除成功');
    }
}
