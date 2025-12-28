<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email,' . $this->route('author')->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الكاتب مطلوب',
            'name.max' => 'اسم الكاتب يجب أن لا يتجاوز 255 حرفاً',
            'email.required' => 'البريد الإلكتروني للكاتب مطلوب',
            'email.email' => 'الرجاء إدخال بريد إلكتروني صحيح للكاتب',
            'email.unique' => 'هذا البريد الإلكتروني للكاتب مستخدم مسبقاً',
        ];
    }
}