<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'category' => 'required|string|max:100',
            'name'     => 'required|string|max:100',
            'icon'     => 'nullable|string|max:100',
            'level'    => 'required|in:beginner,intermediate,advanced,expert',
            'order'    => 'integer|min:0',
        ];
    }
}
