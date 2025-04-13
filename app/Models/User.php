<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    //định nghĩa phân quyền
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //Mặc định khi đăng ký tài khoản phải có role là user
    protected $attributes = [
        'role' => self::ROLE_USER,
    ];
    // kiểm tra người dùng có phải là role admin hay không
    public function isRoleAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }
    //khoái ngoại đên shoppingcart
    public function shoppingcarts(){
        return $this->hasMany(ShoppingCart::class);
    }
    public function customer(){
        return $this->hasOne(Customer::class);
    }
}
