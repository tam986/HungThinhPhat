<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hoten',
        'email',
        'password',
        'sodienthoai',
        'diachi',
        'quyen',
        'hinh',
        'giotinh',
        'last_login',
        'last_logout'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];




    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function binhluan()
    {
        return $this->hasMany(BinhLuan::class);
    }

    // public function isAdmin()
    // {

    //     return $this->quyen === 1;
    // }
}
