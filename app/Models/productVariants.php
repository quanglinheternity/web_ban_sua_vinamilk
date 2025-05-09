<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productVariants extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable=[
        'product_id',
        'size_ml_id',
    ];
    protected $dates=['deleted_at'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function sizeMl(){
        return $this->belongsTo(sizeMl::class, 'size_ml_id');
    }
    public function detailProductVariants(){
        return $this->hasMany(detailProductVariants::class, 'product_variant_id');
    }

}
