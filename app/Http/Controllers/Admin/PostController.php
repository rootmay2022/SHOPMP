<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() { return view('admin.posts.index'); }
    public function create() { return view('admin.posts.create'); }
    public function store(Request $request) { /* Xử lý thêm bài viết */ }
    public function edit($id) { return view('admin.posts.edit', compact('id')); }
    public function update(Request $request, $id) { /* Xử lý cập nhật bài viết */ }
    public function destroy($id) { /* Xử lý xóa bài viết */ }
}
