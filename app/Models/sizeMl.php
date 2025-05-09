<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sizeMl extends Model
{
    use SoftDeletes , HasFactory;
    protected $fillable = [
        'size_ml_code',
        'size_ml_name',
        'status',
    ];
    public function productVariants(){
        return $this->hasMany(productVariants::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }
}
