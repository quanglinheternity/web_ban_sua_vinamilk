<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartDetails extends Model
{
    /** @use HasFactory<\Database\Factories\CartDetailsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gio_hang_id',
        'san_pham_id',
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


}
