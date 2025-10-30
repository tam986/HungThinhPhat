<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giohang extends Model
{
    use HasFactory;

    // Cho phép mass assignment
    protected $fillable = [
        'id_user',
        'id_sanpham',
        'soluong',
        'gia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Bienthe::class);
    }
}
