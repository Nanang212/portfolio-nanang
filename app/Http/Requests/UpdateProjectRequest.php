<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title_id'       => 'required|string|max:255',
            'title_en'       => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'tech_stack'     => 'nullable|string',
            'github_url'     => 'nullable|url|max:500',
            'demo_url'       => 'nullable|url|max:500',
            'image'          => 'nullable|image|max:51200',
            'images'         => 'nullable|array|max:10',
            'images.*'       => 'image|max:51200',
            'remove_images'  => 'nullable|array',
            'remove_images.*'=> 'string',
            'is_published'   => 'boolean',
            'order'          => 'integer|min:0',
        ];
    }
}
