<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'محتوى التعليق مطلوب',
            'post_id.required' => 'معرف المقال مطلوب',
            'post_id.exists' => 'المقال المحدد غير موجود',
        ];
    }
}