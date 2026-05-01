<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Sử dụng cột type và position để phân loại và sắp xếp
        $categories = Category::with('parent')->where('type', 'child')->orderBy('position', 'asc')->orderBy('name', 'asc')->get();
        $parentCategories = Category::where('type', 'parent')->orderBy('position', 'asc')->orderBy('name', 'asc')->get();
        return view('categories.index', compact('categories', 'parentCategories'));
    }

    public function reorder(Request $request)
    {
        $positions = $request->positions; // Array of IDs in order
        foreach ($positions as $index => $id) {
            Category::where('id', $id)->update(['position' => $index]);
        }
        return response()->json(['success' => true]);
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
