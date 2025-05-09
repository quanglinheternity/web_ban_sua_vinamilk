<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\CartDetails;
use App\Models\detailProductVariants;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        // dd($request->all());
        $userId = auth()->id();

        $productId = $request->input('san_pham_id');
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('so_luong', 1);
        // Kiểm tra số lượng trong kho trước khi thêm vào giỏ hàng
        $productVariant = detailProductVariants::find($variant_id);
        if(!$productVariant || $productVariant->stock < $quantity){
            return redirect()->back()->with('error', 'Số lượng trong kho không đủ để thêm vào giỏ hàng.');

        }
        // Tìm hoặc tạo giỏ hàng cho người dùng
        $cart = ShoppingCart::firstOrCreate(
            ['tai_khoan_id' => $userId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $cartDetail = CartDetails::where('gio_hang_id', $cart->id)
            ->where('san_pham_id', $productId)
            ->where('san_pham_bien_the_id', $variant_id)
            ->first();

        if ($cartDetail) {
            // dd(( $quantity));
            // Kiểm tra số lượng khi tăng số lượng sản phẩm trong giỏ
            if ($productVariant->stock < ( $quantity)) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ để thêm vào giỏ hàng!');
            }

            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $cartDetail->increment('so_luong', $quantity);
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            CartDetails::create([
                'gio_hang_id' => $cart->id,
                'san_pham_id' => $productId,
                'san_pham_bien_the_id' => $variant_id,
                'so_luong' => $quantity,
            ]);
        }
           // Trừ số lượng trong kho
        $productVariant->decrement('stock', $quantity);

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
        ->with('product','detailProductVariants.sizeBox','detailProductVariants.productVariant.sizeMl')->get();
        // Thêm thông tin kích thước để dễ truy cập trong view



        return view('client.cart', compact('chiTietGioHang'));
    }
    public function removeFromCart(Request $request){
        // dd($request->all());
        $userId = auth()->id();
        //tìm giỏ hàng theo tài khoản
        $cart= ShoppingCart::where('tai_khoan_id', $userId)->first();
        if(!$cart){
           return redirect()->back()->with('error','Không tìm thấy giỏ hàng');
        }
        // dd($request->all());
        $productVariant = detailProductVariants::find($request->san_pham_bien_the_id);
        if (!$productVariant) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
        }
        // Trả lại số lượng vào kho
        $productVariant->increment('stock', $request->so_luong);
        //xóa sản phẩm ra khỏi chi tiết giỏ hàng
        CartDetails::where('gio_hang_id', $cart->id)->where('id', $request->san_pham_id)->delete();
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

        $cartDetail = CartDetails::where('id', $request->Id)
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
