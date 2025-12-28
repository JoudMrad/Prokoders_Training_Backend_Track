<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'معرف المقال مطلوب',
            'post_id.exists' => 'المقال المحدد غير موجود',
        ];
    }
}