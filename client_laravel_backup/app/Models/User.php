<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'google_id',
        'email',
        'sodienthoai',
        'diachi',
        'password',
        'hoten',
        'quyen',
        'hinh',
        'gioitinh',
    ];
    protected $hidden = ['password', 'remember_token',];

    public function getAuthPassword()
    {
        return $this->password;
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'timestamp',
            'password' => 'hashed',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }
    public function giohang()
    {
        return $this->hasMany(Giohang::class);
    }

    public function yeuthich()
    {
        return $this->hasMany(Yeuthich::class, 'id_user', 'id');
    }
    public function binhluan()
    {
        return $this->hasMany(BinhLuan::class);
    }
}
