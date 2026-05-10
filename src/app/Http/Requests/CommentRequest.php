<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 评论表单验证
 */
class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.required' => '请输入昵称',
            'nickname.max' => '昵称不能超过50个字符',
            'email.email' => '请输入有效的邮箱地址',
            'content.required' => '请输入评论内容',
            'content.max' => '评论内容不能超过1000个字符',
        ];
    }
}
