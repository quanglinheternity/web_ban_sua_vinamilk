<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',

    ];
    public function scopeSearch($query, $request)
    {
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        return $query;
    }
}
