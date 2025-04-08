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
        'ten_khach_hang',
        'email',
        'so_dien_thoai',
        'dia_chi',
    ];
    public function reviews(){
        return $this->hasMany(Review::class, 'customer_id');
    }
}
