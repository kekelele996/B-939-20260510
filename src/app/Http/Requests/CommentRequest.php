<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 评论表单请求验证
 */
class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'guest_name' => 'required|string|max:50',
            'guest_email' => 'required|email|max:100',
            'content' => 'required|string|min:2|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'guest_name.required' => '请输入您的昵称',
            'guest_name.max' => '昵称不能超过50个字符',
            'guest_email.required' => '请输入您的邮箱',
            'guest_email.email' => '请输入有效的邮箱地址',
            'guest_email.max' => '邮箱不能超过100个字符',
            'content.required' => '请输入评论内容',
            'content.min' => '评论内容至少需要2个字符',
            'content.max' => '评论内容不能超过2000个字符',
        ];
    }
}
