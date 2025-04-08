<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'reviews';
    protected $fillable=[

        'rating',
        'comment'
    ];
    protected $dates = ['deleted_at'];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function scopeSearch($query, $request)
{
    if ($request->filled('product_name') && $request->product_name !== '') {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('ten_san_pham', 'like', '%' . $request->product_name . '%');
        });
    }

    if ($request->filled('customer_name') && $request->customer_name !== '') {
        $query->whereHas('customer', function ($q) use ($request) {
            $q->where('ten_khach_hang', 'like', '%' . $request->customer_name . '%');
        });
    }

    if ($request->filled('rating') && $request->rating !== '') {
        $query->where('rating', $request->rating);
    }

    return $query;
}




}
