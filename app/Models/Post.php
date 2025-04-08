<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory,SoftDeletes;
    protected $table='posts';
    protected $fillable=[
        'title',
        'content',
        'image',
        'status',
    ];
    public function getRouteKeyName()
    {
        return 'title'; // Tìm bài viết theo slug thay vì ID
    }

    protected $dates=['deleted_at'];
}
