<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $table = 'customers';
    protected $fillable=[

        'so_dien_thoai',
        'dia_chi',
        'anh_dai_dien',
        'ngay_sinh',
        'gioi_tinh',
        'user_id'
    ];
    public function reviews(){
        return $this->hasMany(Review::class, 'customer_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
