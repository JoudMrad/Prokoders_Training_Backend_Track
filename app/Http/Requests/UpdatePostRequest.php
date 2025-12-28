<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'topic_ids' => 'nullable|array',
            'topic_ids.*' => 'exists:topics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان المقال مطلوب',
            'title.max' => 'عنوان المقال يجب أن لا يتجاوز 255 حرفاً',
            'content.required' => 'محتوى المقال مطلوب',
            'published_at.date' => 'تاريخ النشر يجب أن يكون تاريخاً صحيحاً',
            'category_id.required' => 'التصنيف مطلوب',
            'category_id.exists' => 'التصنيف المحدد غير موجود',
            'author_id.required' => 'الكاتب مطلوب',
            'author_id.exists' => 'الكاتب المحدد غير موجود',
            'topic_ids.array' => 'المواضيع يجب أن تكون مصفوفة',
            'topic_ids.*.exists' => 'الموضوع المحدد غير موجود',
        ];
    }
}