<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentMethodFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = ['ten_phuong_thuc'];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
