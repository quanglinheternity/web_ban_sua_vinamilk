<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    //hàm lấy ra danh sách sản phẩm
    public function index(Request $request ){
        $query = Product::with('categories');
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'like', '%' . $request->ma_san_pham . '%');

        }
        if ($request->filled('ten_san_pham')) {
            $query->where('ten_san_pham', 'like', '%' . $request->ten_san_pham . '%');

        }
        //danh mục khoảng giá, ngày nhập, trạng thái
        if ($request->filled('category_id')) {
            $query->where('category_id', (array) $request->category_id );

        }
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'like', '%' . $request->ma_san_pham . '%');

        }
        if($request->filled('ngay_nhap') ) {
            $query->whereDate('ngay_nhap', $request->ngay_nhap);
        }
        if($request->filled('gia_min') && $request->filled('gia_max')) {
            $query->whereBetween('gia', [$request->gia_min, $request->gia_max]);
        }
        if($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }
        // dd(123);
        //sử dụng Eloquent ORM (query builder)
        $products = $query->latest()->orderBy('trang_thai', 'desc')->paginate(10);
        $categories = Category::all();
        // dd($products);
        // BTVN
        //-Xây dựng master layout của trang admin
        // tạo 1 trang quản lý sản phẩm
        //hiển thị danh sách sản phẩm ra đưới dạng bảng
        return view('admin.products.index', compact('products', 'categories'));

    }
    public function show($id){
        // dd($id);
        $product = Product::with('categories')->findOrFail  ($id);
        // dd($product);
        return view('admin.products.show', compact('product'));
    }
    public function create(){
        $categories = Category::all()->where('trang_thai', 1);
        return view('admin.products.create', compact('categories'));
    }
    public function store(Request $request){
        // dd($request->all());
        // dd($request->category_id);
        $request->validate([
            'ma_san_pham' => 'required|string|max:255|unique:products,ma_san_pham',
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gia' => 'required|numeric|min:0|digits_between:0,10',
            'gia_khuyen_mai' => 'nullable|numeric|lt:gia|digits_between:0,10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'so_luong' => 'required|integer|min:0',
            'trang_thai' => 'required|boolean',
            'ngay_nhap'=> 'required|date',
            'mo_ta' => 'nullable|string',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('uploads/products', 'public');

        };
        // dd($imagePath);
        Product::create([
            'ma_san_pham' => $request->ma_san_pham,
            'ten_san_pham'=> $request->ten_san_pham,
            'category_id' => $request->category_id,
            'img'=> $imagePath,
            'so_luong'=> $request->so_luong,
            'gia'=> $request->gia,
            'gia_khuyen_mai'=> $request->gia_khuyen_mai,
            'mo_ta'=> $request->mo_ta,
            'trang_thai'=> $request->trang_thai,
            'ngay_nhap'=> $request->ngay_nhap,

        ]);
        return redirect()->route('admin.products.index')->with('success' ,'sản phẩm đã được thêm');
    }
    public function edit($id){
        $product = Product::findOrFail($id);
        $categories = Category::all()->where('trang_thai', 1);
        $product->ngay_nhap = \Carbon\Carbon::parse($product->ngay_nhap)->format('Y-m-d');

        // dd($product->ma_san_pham);
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request,$id){
        // dd($request->all());
        // dd($request->category_id);
        $validatedData = $request->validate([
            'ma_san_pham' => "required|string|max:255|unique:products,ma_san_pham, $id",
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gia' => 'required|numeric|min:0|max:999999999',
            'gia_khuyen_mai' => 'nullable|numeric|lt:gia|max:999999999',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'so_luong' => 'required|integer|min:0',
            'trang_thai' => 'required|boolean',
            'ngay_nhap'=> 'required|date',
            'mo_ta' => 'nullable|string',
        ]);
        // dd($request);
        // dd($request->all(), $request->file('img'));

        $product=Product::findOrFail($id);
        if ($request->hasFile('img')) {
            // Kiểm tra và xóa ảnh cũ nếu tồn tại
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }
            // Upload ảnh mới
            $imagePath  = $request->file('img')->store('uploads/products', 'public');
            $validatedData['img'] = $imagePath;
            // dd($validatedData);
        }
        // dd($validatedData);

        $product->update(
            $validatedData
        );
        // dd($product);
        return redirect()->route('admin.products.index')->with('success' ,'sản phẩm đã cập nhập ');
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success' ,'sản phẩm được xóa');
    }
    // 📌 Hiển thị danh sách sản phẩm đã xóa mềm
    public function trashed()
    {
        $products = Product::onlyTrashed()->with('categories'   )->paginate(10);
        return view('admin.products.trashed', compact('products'));
    }
    // 📌 Khôi phục sản phẩm đã xóa mềm
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trashed')->with('success', 'Sản phẩm đã được khôi phục.');
    }
    // 📌 Xóa vĩnh viễn sản phẩm
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        // Nếu sản phẩm có ảnh, xóa luôn ảnh trong storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()->route('admin.products.trashed')->with('success', 'Sản phẩm đã bị xóa vĩnh viễn.');
    }



}
