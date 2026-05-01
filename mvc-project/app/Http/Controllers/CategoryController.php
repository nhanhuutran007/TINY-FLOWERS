<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Sử dụng cột type để phân loại rạch ròi
        $categories = Category::with('parent')->where('type', 'child')->get();
        $parentCategories = Category::where('type', 'parent')->get();
        return view('categories.index', compact('categories', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
            'cat_type' => 'required|in:parent,child',
            'parent_id' => $request->cat_type === 'child' ? 'required|exists:categories,id' : 'nullable'
        ]);

        $data = $request->all();
        $data['type'] = $request->cat_type;
        if ($request->cat_type === 'parent') {
            $data['parent_id'] = null;
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'cat_type' => 'required|in:parent,child',
            'parent_id' => $request->cat_type === 'child' ? 'required|exists:categories,id' : 'nullable'
        ]);

        $data = $request->all();
        $data['type'] = $request->cat_type;
        if ($request->cat_type === 'parent') {
            $data['parent_id'] = null;
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
