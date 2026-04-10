<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'icon',
        'level',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('category')->orderBy('order');
    }

    public static function groupedByCategory(): array
    {
        return static::ordered()->get()->groupBy('category')->map(fn($items) => $items->values())->toArray();
    }
}
