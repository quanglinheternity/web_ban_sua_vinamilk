<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\CartDetails;
use App\Models\Order;
use App\Models\ShoppingCart;
use App\Models\User;
use DragonCode\Support\Helpers\Str;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request){
        // dd($request->all());

        $tongTien = $request->tong_gio_hang;
        //lấy thông tin dữ liệu giỏ hàng
        // return view('client.For', compact('chiTietGioHang', 'tongTien','User'));
        session(['tongTien' => $tongTien ?? 0]);
        return redirect()->route('client.checkout.showForm');
    }
    public function showForm(Request $request)
    {
    // dd(session()->all());
        //lấy thông tin dữ liệu giỏ hàng
        $UserId = auth()->id();
        //lấy thông tin người đăng nhập
        $User = User::with('customer')->where('id', $UserId)->first();

        // dd($User->customer->so_dien_thoai);
        $gioHang= ShoppingCart::where('tai_khoan_id', $UserId)->first();
        // dd($gioHang);
        $tongTien = session()->get('tongTien');

        $chiTietGioHang = CartDetails::where('gio_hang_id', $gioHang->id)
        ->with('product','detailProductVariants.sizeBox','detailProductVariants.productVariant.sizeMl')->get();
        // dd($chiTietGioHang->product);
        return view('client.FormCheckout', [
            'chiTietGioHang' => $chiTietGioHang,
            'tong_tien' => $tongTien ?? 0,
            'User' => $User,
        ]);
    }

    public function store(Request $request){
        // dd($request->all());
        // Validate dữ liệu

        $validated = $request->validate([
            'tong_tien' => 'required|numeric|min:0',
            'ten_nguoi_nhan' => 'required|string|max:255',
            'email_nguoi_nhan' => 'required|email|max:255',
            'sdt_nguoi_nhan' => 'required|string|regex:/^([0-9]{10,11})$/',
            'dia_chi_nguoi_nhan' => 'required|string|max:500',
            'ghi_chu' => 'nullable|string|max:1000',
            'phuong_thuc_thanh_toan' => 'required',
            'confirmOrder' => 'accepted',
        ], [
            // Các thông báo lỗi tuỳ chỉnh
            'tong_tien.required' => 'Vui lòng nhập tổng tiền.',
            'tong_tien.numeric' => 'Tổng tiền phải là một số.',
            'tong_tien.min' => 'Tổng tiền không thể nhỏ hơn 0.',
            'ten_nguoi_nhan.required' => 'Tên người nhận không được để trống.',
            'email_nguoi_nhan.required' => 'Email người nhận không được để trống.',
            'email_nguoi_nhan.email' => 'Email không hợp lệ.',
            'sdt_nguoi_nhan.required' => 'Số điện thoại không được để trống.',
            'sdt_nguoi_nhan.regex' => 'Số điện thoại phải chứa từ 10 đến 11 chữ số.',
            'dia_chi_nguoi_nhan.required' => 'Địa chỉ người nhận không được để trống.',
            'phuong_thuc_thanh_toan.required' => 'Vui lòng chọn phương thức thanh toán.',
            'confirmOrder.accepted' => 'Bạn phải xác nhận đơn hàng trước khi tiếp tục.',
        ]);

        // dd($validated);
        // Tạo đơn hàng
        $order = Order::create([
            'order_code' => 'ORD-' . \DragonCode\Support\Facades\Helpers\Str::random(8),
            'ma_don_hang' => 'ORD-' . \DragonCode\Support\Facades\Helpers\Str::random(8),
            'tai_khoan_id' => Auth::id(),
            'tong_tien' => $validated['tong_tien'],
            'ten_nguoi_nhan' => $validated['ten_nguoi_nhan'],
            'email_nguoi_nhan' => $validated['email_nguoi_nhan'],
            'so_dien_thoai' => $validated['sdt_nguoi_nhan'],
            'dia_chi_nhan_hang' => $validated['dia_chi_nguoi_nhan'],
            'ngay_dat_hang' => now(),
            'ghi_chu' => $validated['ghi_chu'],
            'phuong_thuc_id' => '1',
            'trang_thai_thanh_toan' => 'pending', // Chưa thanh toán
            'trang_thai_id' => '1',
        ]);
        //xóa gio hàng
        $gioHang= ShoppingCart::where('tai_khoan_id', auth()->id())->first();
        $chi_tiet_gio_hang=CartDetails::where('gio_hang_id', $gioHang->id)->with('product','detailProductVariants.sizeBox','detailProductVariants.productVariant.sizeMl')->get();
        // dd($chi_tiet_gio_hang);
        foreach ($chi_tiet_gio_hang as $item) {
            // Tạo chi tiết đơn hàng
            $tong_tien = $item->so_luong * ($item->detailProductVariants->promotional_price ?? $item->detailProductVariants->price);
            // dd($item->detailProductVariants->size_box_id);
            $order->orderDetails()->create([
                'don_hang_id' => $item->san_pham_id,
                'san_pham_bien_the_id' => $item->san_pham_bien_the_id,
                'so_luong' => $item->so_luong,
                'tong_tien' => $tong_tien,
                'size_ml_id' => $item->detailProductVariants->productVariant->size_ml_id,
                'size_box_id' => $item->detailProductVariants->size_box_id,
            ]);

        }
        // dd('done');
        //xóa chia tiết giỏ hàng
        CartDetails::where('gio_hang_id', $gioHang->id)->delete();
        //xóa giỏ hàng
        ShoppingCart::where('tai_khoan_id', auth()->id())->delete();
        // Xử lý theo phương thức thanh toán
        if ($validated['phuong_thuc_thanh_toan'] === '1') {
            // COD: Không cần cổng thanh toán, chuyển thẳng đến trang thành công
            return redirect()->route('client.checkout.success')->with('success', 'Đặt hàng thành công! Bạn sẽ thanh toán khi nhận hàng.');
        } elseif ($validated['phuong_thuc_thanh_toan'] === '2') {
            // VNPay: Tạo link thanh toán
            $vnpayUrl = $this->createVnpayUrl($order);
            return redirect()->to($vnpayUrl);
        }
        session()->forget('tongTien');
        return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');

    }
    private function createVnpayUrl($order)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh'); // ✅ Chèn vào đây


        $vnp_TmnCode = "QPXWR5AA"; // Mã website của bạn tại VNPay
        $vnp_HashSecret = "QIHQDAWOX1AH1P0CZ96RBWLLB00N3NZE"; // Chương trình bí mật; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL sandbox để test
        $vnp_Returnurl = route('client.checkout.vnpay.callback');

        $vnp_TxnRef = $order->order_code; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng {$order->order_code}";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $order->tong_tien * 100; // Số tiền (VND, nhân 100 theo yêu cầu VNPay)
        $vnp_Locale = "vn";
        $vnp_BankCode = ""; // Để trống để người dùng chọn ngân hàng
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        if ($vnp_BankCode !== "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if ($vnp_HashSecret) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    public function vnpayCallback(Request $request)
    {
        $vnp_HashSecret = "SECRETKEYTEST123";
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $order = Order::where('order_code', $request->vnp_TxnRef)->first();

        if ($order && $secureHash === $vnp_SecureHash && $request->vnp_ResponseCode == '00') {
            // Thanh toán thành công
            $order->update([
                'trang_thai_thanh_toan' => 'paid',
                'trang_thai_don_hang' => 'confirmed',
            ]);
            return redirect()->route('client.checkout.success')->with('success', 'Thanh toán VNPay thành công!');
        } else {
            // Thanh toán thất bại
            $order->update(['trang_thai_don_hang' => 'failed']);
            return redirect()->route('client.FromCheckout')->with('error', 'Thanh toán VNPay thất bại.');
        }
    }
    public function success()
    {
        return view('client.success');
    }
}
