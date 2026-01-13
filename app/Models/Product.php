<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'beauty_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'image',
        'category',
        'brand',
        'stock',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Scope để lấy sản phẩm nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    // Scope để lấy sản phẩm theo danh mục
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category)->where('is_active', true);
    }

    // Scope để lấy sản phẩm theo thương hiệu
    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand)->where('is_active', true);
    }

    // Kiểm tra có giảm giá không
    public function hasDiscount()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    // Tính phần trăm giảm giá
    public function getDiscountPercentage()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    // Format giá
    public function getFormattedPrice()
    {
        return number_format($this->price) . 'đ';
    }

    public function getFormattedOldPrice()
    {
        return number_format($this->old_price) . 'đ';
    }

    // Relationship to category by name column
    public function category()
    {
        // Maps product's 'category' (name string) to categories.name
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    // Relationship to brand by name column
   
} 