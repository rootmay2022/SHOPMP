<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'description', 
        'image',
        'link',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Scope để lấy banner active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope để lấy banner theo thứ tự
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
