<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:topics,name,' . $this->route('topic')->id,
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموضوع مطلوب',
            'name.max' => 'اسم الموضوع يجب أن لا يتجاوز 255 حرفاً',
            'name.unique' => 'اسم الموضوع مستخدم مسبقاً',
            'description.string' => 'الوصف يجب أن يكون نصاً',
        ];
    }
}