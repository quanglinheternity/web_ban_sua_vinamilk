<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    /** @use HasFactory<\Database\Factories\CartDetailsFactory> */
    use HasFactory;

    protected $fillable = [
        'gio_hang_id',
        'san_pham_id',
        'san_pham_bien_the_id',
        'so_luong',
    ];

    public function gio_hang()
    {
        return $this->belongsTo(ShoppingCart::class, 'gio_hang_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'san_pham_id');
    }

    public function detailProductVariants()
    {
        return $this->belongsTo(detailProductVariants::class, 'san_pham_bien_the_id');
    }


}
