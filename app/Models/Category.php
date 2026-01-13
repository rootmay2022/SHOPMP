<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationship với products
    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }

    // Scope để lấy danh mục active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 