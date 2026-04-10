<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    use HasFactory;

    protected $table = 'about_me';

    protected $fillable = [
        'bio_id',
        'bio_en',
        'photo_path',
        'resume_path',
        'job_title_id',
        'job_title_en',
        'highlights',
    ];

    protected $casts = [
        'highlights' => 'array',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) return null;
        return asset('storage/' . $this->photo_path);
    }
}
