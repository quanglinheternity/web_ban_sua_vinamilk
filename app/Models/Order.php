<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'ma_don_hang',
        'tai_khoan_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'dia_chi_nhan_hang',
        'ngay_dat_hang',
        'tong_tien',
        'trang_thai_id',
        'phuong_thuc_id',
        'ghi_chu',
        'email_nguoi_nhan',
        'trang_thai_thanh_toan',
        'order_code',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'trang_thai_id');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'phuong_thuc_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'don_hang_id');
    }
}
