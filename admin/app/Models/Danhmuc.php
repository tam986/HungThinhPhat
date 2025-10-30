<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danhmuc extends Model
{
    use HasFactory;

    protected $table = 'danhmucs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tendanhmuc',
        'thutu',
        'anhien',
        'mota',
    ];

    // 1-N
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_danhmuc', 'id');
    }
}
