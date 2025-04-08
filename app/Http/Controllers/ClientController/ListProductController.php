<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    public function index(Request $request){
        $listCategories = Category::all();
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
        $productByCategory = Product::with('categories')->where('category_id', $product->category_id)->get();
        $comments = Review::with(['product', 'customer'])->where('product_id', $product->id)->get();
        return view('client.showProduct', compact('product', 'productByCategory', 'comments'));
    }
}
