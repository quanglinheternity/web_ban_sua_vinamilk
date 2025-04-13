<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $listBanners = Banner::all()->where('status',1);
        $top5Products = Product::where('trang_thai',1)->orderBy('id', 'asc')->take(4)->get();
        $listProducts = Product::latest()->take(8)->get()->where('trang_thai',1);
        $top5DanhGia= Review::with('product','customer')->where('status',1)->get()->take(4);
        $listNews = Post::latest()->get()->where('status',1);
        // dd($top5Products);
        return view('client.index',compact('listBanners','top5Products','listProducts','top5DanhGia','listNews'));
    }
}
