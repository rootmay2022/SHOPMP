<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->orderBy('sort_order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:1|max:999',
            'is_active' => 'nullable'
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề banner',
            'title.min' => 'Tiêu đề phải có ít nhất 3 ký tự',
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'description.max' => 'Mô tả không được quá 1000 ký tự',
            'image.required' => 'Vui lòng chọn ảnh banner',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: JPG, PNG, GIF',
            'image.max' => 'Ảnh không được quá 2MB',
            'link.max' => 'Link không được quá 500 ký tự',
            'sort_order.min' => 'Thứ tự phải lớn hơn 0',
            'sort_order.max' => 'Thứ tự không được quá 999'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Lưu ảnh vào public/images/product
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            $data['image'] = 'images/product/' . $imageName;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? Banner::max('sort_order') + 1;

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Thêm banner thành công!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('=== BANNER UPDATE START ===');
        \Log::info('Banner update request', ['id' => $id, 'data' => $request->all()]);
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:1|max:999',
            'is_active' => 'nullable'
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề banner',
            'title.min' => 'Tiêu đề phải có ít nhất 3 ký tự',
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'description.max' => 'Mô tả không được quá 1000 ký tự',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: JPG, PNG, GIF',
            'image.max' => 'Ảnh không được quá 2MB',
            'link.max' => 'Link không được quá 500 ký tự',
            'sort_order.min' => 'Thứ tự phải lớn hơn 0',
            'sort_order.max' => 'Thứ tự không được quá 999'
        ]);

        if ($validator->fails()) {
            \Log::info('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \Log::info('Validation passed, finding banner...');
        $banner = Banner::findOrFail($id);
        $data = $request->all();
        
        \Log::info('Banner found', ['banner' => $banner->toArray()]);

        // Lưu ảnh mới vào public/images/product
        if ($request->hasFile('image')) {
            \Log::info('Processing new image upload...');
            // Xóa ảnh cũ nếu là ảnh local
            if ($banner->image && !str_starts_with($banner->image, 'http') && file_exists(public_path($banner->image))) {
                @unlink(public_path($banner->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            $data['image'] = 'images/product/' . $imageName;
            \Log::info('New image saved', ['path' => $data['image']]);
        } else {
            \Log::info('No new image uploaded, keeping existing image');
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? $banner->sort_order;
        
        \Log::info('Data to update', ['data' => $data]);

        try {
            $banner->update($data);
            \Log::info('Banner updated successfully in database');
        } catch (\Exception $e) {
            \Log::error('Error updating banner', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Lỗi cập nhật banner: ' . $e->getMessage());
        }
        
        \Log::info('=== BANNER UPDATE END ===');

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật banner thành công!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Xóa ảnh
        if ($banner->image && Storage::exists(str_replace('storage/', 'public/', $banner->image))) {
            Storage::delete(str_replace('storage/', 'public/', $banner->image));
        }
        
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Xóa banner thành công!');
    }

    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => !$banner->is_active]);
        
        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật trạng thái banner thành công!');
    }
}
