<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sizeBox extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['size_box_code', 'size_box_name' , 'status'];
    public function detailProductVariants(){
        return $this->hasMany(detailProductVariants::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }

}
