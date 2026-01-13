<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() { return view('admin.menus.index'); }
    public function create() { return view('admin.menus.create'); }
    public function store(Request $request) { /* Xử lý thêm menu */ }
    public function edit($id) { return view('admin.menus.edit', compact('id')); }
    public function update(Request $request, $id) { /* Xử lý cập nhật menu */ }
    public function destroy($id) { /* Xử lý xóa menu */ }
}
