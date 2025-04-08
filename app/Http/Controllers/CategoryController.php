<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(request $request){
        $query = Category::query();
        if ($request->filled('ten_danh_muc')) {
            $query->where('ten_danh_muc', 'like', '%' . $request->ten_danh_muc . '%');

        }
        $categories= $query->latest()->orderBy('trang_thai', 'desc')->paginate(10);
        return view('admin.categories.index' , compact('categories'));
    }
    public function create(){
        return view('admin.categories.create');
    }
    public function store(Request $request){
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255|unique:categories,ten_danh_muc',
            'trang_thai' => 'required|boolean',
        ]);
        Category::create([
            'ten_danh_muc' => $request->ten_danh_muc,
            'trang_thai'=> $request->trang_thai,
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm');
    }
    public function edit(Request $request, $id){
        $category= Category::findOrFail($id);
        return view('admin.categories.edit',compact('category'));
    }
    public function update(Request $request,$id){
        $validateData=$request->validate([
            'ten_danh_muc' => "required|string|max:255|unique:categories,ten_danh_muc,$id",
            'trang_thai' => 'required|boolean',
        ]);
        $category=Category::findOrFail($id);
        $category->update(
            $validateData
        );
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật');
    }
    public function destroy($id){
        Category::destroy($id);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa');

    }
     // Hiển thị danh mục đã xóa mềm
     public function trashed()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.categories.trashed', compact('categories'));
    }


     // Khôi phục danh mục đã xóa mềm
     public function restore($id)
     {
         $category = Category::onlyTrashed()->findOrFail($id);
         $category->restore();

         return redirect()->route('admin.categories.trashed')->with('success', 'Danh mục đã được khôi phục.');
     }

     // Xóa vĩnh viễn danh mục
     public function forceDelete($id)
     {
         $category = Category::onlyTrashed()->findOrFail($id);
         $category->forceDelete();

         return redirect()->route('admin.categories.trashed')->with('success', 'Danh mục đã bị xóa vĩnh viễn.');
     }

}

