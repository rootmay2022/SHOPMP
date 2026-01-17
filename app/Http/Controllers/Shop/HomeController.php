<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // Sử dụng lệnh đơn giản nhất để tránh lỗi Scope nếu bạn chưa định nghĩa
        $banners = Banner::where('id', '>', 0)->get(); 
        $featuredProducts = Product::take(4)->get();
        $categories = Category::where('id', '>', 0)->get();

        // Kiểm tra xem file view có đúng tên là 'home.blade.php' không
        return view('home', compact('banners', 'featuredProducts', 'categories'));
    }
}