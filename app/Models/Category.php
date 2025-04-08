<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    // model muốn thao tác vs bảo ng nào thì chúng ta sẽ quy định ở biến table
    protected $table = 'categories';
    //$filllable cho phép điền đữ liệu vào các cột tương ứng
    protected $fillable=[
        'ten_danh_muc',
        'trang_thai'
    ];
    protected $dates=['deleted_at'];
    //tạo muốn quan hệ với bảng Product (1-N)
    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

}
