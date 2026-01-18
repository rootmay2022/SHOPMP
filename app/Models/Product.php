<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng trong database
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

    // --- SCOPES: Giúp truy vấn nhanh ---

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // --- RELATIONSHIPS: Liên kết bảng ---

    /**
     * Liên kết với bảng categories qua cột 'category' (name)
     */
    public function categoryRel()
    {
        // Sử dụng 'categoryRel' để tránh trùng tên với cột 'category' trong DB
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    /**
     * Liên kết với bảng brands qua cột 'brand' (name)
     */
    public function brandRel()
    {
        return $this->belongsTo(Brand::class, 'brand', 'name');
    }

    // --- HELPER METHODS: Hàm hỗ trợ hiển thị ---

    public function hasDiscount()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    public function getDiscountPercentage()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    public function getFormattedPrice()
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    public function getFormattedOldPrice()
    {
        return $this->old_price ? number_format($this->old_price, 0, ',', '.') . 'đ' : '';
    }
}
