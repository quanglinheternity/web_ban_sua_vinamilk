<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable=[
        'ma_san_pham',
        'ten_san_pham',
        'category_id',
        'img',
        'gia',
        'gia_khuyen_mai',
        'so_luong',
        'ngay_nhap',
        'mo_ta',
        'trang_thai',
    ];
    protected $dates = ['deleted_at'];
    // tạo muốn quan hệ vs bảng categories
    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function reviews(){
        return $this->hasMany(Review::class, 'product_id');
    }
    public function albumImages(){
        return $this->hasMany(AlbumImgae::class, 'product_id');
    }
}
