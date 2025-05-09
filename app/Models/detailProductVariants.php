<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detailProductVariants extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'product_variant_id',
        'variant_code',
        'variant_name',
        'price',
        'promotional_price',
        'stock',
        'size_box_id',
    ];
    public function productVariant(){
        return $this->belongsTo(productVariants::class, 'product_variant_id');
    }
    public function sizeBox(){
        return $this->belongsTo(sizeBox::class, 'size_box_id');
    }
    public function cartDetails(){
        return $this->hasMany(CartDetails::class, 'san_pham_bien_the_id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class, 'san_pham_bien_the_id');
    }
}
