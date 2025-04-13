<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListProductController extends Controller
{
    public function index(Request $request){
        $listCategories = Category::all()->where('trang_thai', 1);
        $query = Product::with('categories')->where('trang_thai', 1);
        if($request->filled('category_id')){
            $query->where('category_id', $request->category_id);
        }
        $listProducts = $query->paginate(9);
        // $listCategory = Category::all();

        return view('client.ListProduct', compact('listCategories', 'listProducts'));
    }
    public function showProduct($id){
        $product = Product::with('categories')->findOrFail($id);
        $productByCategory = Product::with('categories')->where('trang_thai', 1)->where('category_id', $product->category_id)->get();
        $comments = Review::with(['product', 'customer'])->where('product_id', $product->id)->get();
        return view('client.showProduct', compact('product', 'productByCategory', 'comments'));
    }
    public function reviewsStore(Request $request){
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'customer_id' => 'required|integer|exists:users,id',
            'noi_dung' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm',
            'customer_id.required' => 'Vui lòng chọn khách hàng',
            'noi_dung.required' => 'Vui lòng nhập biến đánh giá',
            'rating.required' => 'Vui lòng nhập đánh giá',
        ]);
        // dd($request->product_id);
        // Lưu bình luận vào DB
        Review::create([
            'product_id' =>  $request->product_id,
            'customer_id' => $request->customer_id,
            'comment' => $request->noi_dung,
            'rating' => $request->rating,
        ]);
        return redirect()->back()->with('success', 'Bạn đã đánh giá thành công');
    }

}
