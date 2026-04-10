<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company'      => 'required|string|max:255',
            'role'         => 'required|string|max:255',
            'period_start' => 'required|date',
            'period_end'   => 'nullable|date|after_or_equal:period_start',
            'is_current'   => 'boolean',
            'tech_stack'   => 'nullable|string',
            'projects'     => 'nullable|array',
            'projects.*.name' => 'required|string|max:255',
            'projects.*.description_id' => 'required|string',
            'projects.*.description_en' => 'required|string',
            'order'        => 'integer|min:0',
        ];
    }
}
