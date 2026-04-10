<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'role',
        'period_start',
        'period_end',
        'is_current',
        'projects',
        'tech_stack',
        'order',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
        'is_current'   => 'boolean',
        'projects'     => 'array',
        'tech_stack'   => 'array',
        'order'        => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('period_start');
    }
}
