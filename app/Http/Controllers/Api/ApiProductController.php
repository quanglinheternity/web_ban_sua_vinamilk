<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
