<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailsFactory> */
    use HasFactory, SoftDeletes;
    public $fillable = [
        'don_hang_id',
        'san_pham_bien_the_id',
        'size_ml_id',
        'size_box_id',
        'so_luong',
        'tong_tien',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'don_hang_id');
    }
    public function detailProductVariants()
    {
        return $this->belongsTo(detailProductVariants::class);
    }
    public function sizeMl()
    {
        return $this->belongsTo(sizeMl::class);
    }
    public function sizeBox()
    {
        return $this->belongsTo(sizeBox::class);
    }
}
