<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $this->user()->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرفاً',
            'email.string' => 'البريد الإلكتروني يجب أن يكون نصاً',
            'email.email' => 'الرجاء إدخال بريد إلكتروني صحيح',
            'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرفاً',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم مسبقاً',
        ];
    }
}