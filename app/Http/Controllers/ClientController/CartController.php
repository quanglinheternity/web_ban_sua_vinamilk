<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\CartDetails;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        // dd($request->all());
        $userId = auth()->id();


        $productId = $request->input('san_pham_id');
        $quantity = $request->input('so_luong', 1);

        // Tìm hoặc tạo giỏ hàng cho người dùng
        $cart = ShoppingCart::firstOrCreate(
            ['tai_khoan_id' => $userId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $cartDetail = CartDetails::where('gio_hang_id', $cart->id)
            ->where('san_pham_id', $productId)
            ->first();

        if ($cartDetail) {
            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $cartDetail->increment('so_luong', $quantity);
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            CartDetails::create([
                'gio_hang_id' => $cart->id,
                'san_pham_id' => $productId,
                'so_luong' => $quantity,
            ]);
        }

        return redirect()->route('client.cartView')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');

    }
    public function cartView(){
        $userId = auth()->id();
        // Tìm hoặc tạo giỏ hàng cho người dùng
        $cart= ShoppingCart::firstOrCreate(
            ['tai_khoan_id' => $userId],
            ['created_at' => now(), 'updated_at' => now()]
        );
        //lấy chi tiết giỏ hàng
        $chiTietGioHang = CartDetails::where('gio_hang_id', $cart->id)
        ->with('product')->get();
        // dd($chiTietGioHang->product);
        return view('client.cart', compact('chiTietGioHang'));
    }
    public function removeFromCart(Request $request){
        $userId = auth()->id();
        //tìm giỏ hàng theo tài khoản
        $cart= ShoppingCart::where('tai_khoan_id', $userId)->first();
        if(!$cart){
           return redirect()->back()->with('error','Không tìm thấy giỏ hàng');
        }
        // dd($request->all());

        //xóa sản phẩm ra khỏi chi tiết giỏ hàng
        CartDetails::where('gio_hang_id', $cart->id)->where('san_pham_id', $request->san_pham_id)->delete();
        // dd($cartDetail);
        // return redirect()->route('client.cartView')->with('success', 'Sản phẩm được xóa khỏi giỏ hàng.');
        return response()->json(['success' => 'Sản phẩm được xóa khỏi giỏ hàng']);
    }
    public function updateCartQuantity(Request $request)
    {
        $userId = auth()->id();
        $cart = ShoppingCart::where('tai_khoan_id', $userId)->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy giỏ hàng.']);
        }

        $cartDetail = CartDetails::where('gio_hang_id', $cart->id)
                                ->where('san_pham_id', $request->san_pham_id)
                                ->first();

        if ($cartDetail) {
            $cartDetail->so_luong = $request->so_luong;
            $cartDetail->save();
            return response()->json(['success' => true, 'message' => 'Cập nhật số lượng giỏ hàng thành công.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.']);
        }
    }

}
