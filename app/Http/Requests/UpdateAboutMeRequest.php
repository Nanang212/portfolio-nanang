<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutMeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'bio_id'       => 'required|string',
            'bio_en'       => 'required|string',
            'job_title_id' => 'required|string|max:255',
            'job_title_en' => 'required|string|max:255',
            'highlights'   => 'nullable|string',
            'photo'        => 'nullable|image|max:2048',
        ];
    }
}
