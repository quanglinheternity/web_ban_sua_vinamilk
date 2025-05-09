<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingCart extends Model
{
    /** @use HasFactory<\Database\Factories\ShoppingCartFactory> */
    use HasFactory;

    protected $fillable = [
        'tai_khoan_id',
    ];

    public function customer(){
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }
    public function cart_details(){
        return $this->hasMany(CartDetails::class, 'gio_hang_id');
    }
}
