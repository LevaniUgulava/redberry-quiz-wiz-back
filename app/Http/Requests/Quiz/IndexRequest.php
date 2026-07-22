<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter'=>['nullable', 'string'],
            'search' => ['nullable', 'string'],
            'category' => ['nullable', 'array'],
            'difficulty_ids' => ['nullable', 'array'],
            'sort_by' => ['nullable', 'string'],
            'perPage' => ['nullable', 'integer', 'min:1', 'max:20'],
        ];
    }
}
