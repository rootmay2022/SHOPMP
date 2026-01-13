<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Bộ sưu tập thời trang mới',
                'description' => 'Khám phá những sản phẩm làm đẹp mới nhất với ưu đãi lên đến 50%',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1200&h=400&fit=crop',
                'link' => '/products',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Son môi cao cấp',
                'description' => 'Bộ sưu tập son môi với màu sắc đa dạng, chất lượng cao cấp',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=1200&h=400&fit=crop',
                'link' => '/products?category=Son môi',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Kem dưỡng ẩm tự nhiên',
                'description' => 'Chăm sóc da với các thành phần tự nhiên, an toàn cho mọi loại da',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=1200&h=400&fit=crop',
                'link' => '/products?category=Kem dưỡng',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Phấn trang điểm chuyên nghiệp',
                'description' => 'Tạo lớp nền hoàn hảo với bộ phấn trang điểm chất lượng cao',
                'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=1200&h=400&fit=crop',
                'link' => '/products?category=Phấn trang điểm',
                'sort_order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
