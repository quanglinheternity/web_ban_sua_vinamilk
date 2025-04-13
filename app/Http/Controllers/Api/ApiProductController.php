<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        $products = Product::with('categories')->latest()->paginate(10);
        $categories = Category::all();
        // dd($products);
        // BTVN
        //-Xây dựng master layout của trang admin
        // tạo 1 trang quản lý sản phẩm
        //hiển thị danh sách sản phẩm ra đưới dạng bảng
        // return response()->json($products, 200);
        return response()->json([
            'message' => 'Lấy sản phẩm thành công',
            'status' =>200,
            'data'=> ProductResource::collection($products  ),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $Product = Product::create([
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
        return response()->json($Product,201);
        // return response()->json([
        //     'satus' => 201,
        //     'message' => 'Thêm sản phẩm thành công',
        //     'data' => new ProductResource($Product)
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // dd($id);
         $product = Product::with('categories')->findOrFail  ($id);
         // dd($product);
         return response()->json($product, 200);
        //sửa dụng resource controller
        // return ProductResource::collection($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Xóa thành công'], 200);
    }
    public function restore(){

    }
    public function forceDelete(){

    }
}
