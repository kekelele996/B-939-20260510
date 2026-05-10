<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 文章表单验证
 */
class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('article')?->id;

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                Rule::unique('articles')->ignore($articleId),
            ],
            'category_id' => ['nullable', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '请输入文章标题',
            'title.max' => '标题不能超过200个字符',
            'slug.unique' => 'URL别名已被使用',
            'content.required' => '请输入文章内容',
            'category_id.exists' => '选择的分类不存在',
            'tags.*.exists' => '选择的标签不存在',
        ];
    }
}
