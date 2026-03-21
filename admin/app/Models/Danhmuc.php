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
        'img',
    ];

    protected $appends = ['slug', 'img_url'];

    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : null;
    }
    
    public function getSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->tendanhmuc);
    }

    // 1-N
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_danhmuc', 'id');
    }

    // Biến thể qua bảng sanphams (dùng để eager-load tránh N+1)
    public function bienthes()
    {
        return $this->hasManyThrough(
            Bienthe::class,
            Sanpham::class,
            'id_danhmuc', // FK trên bảng sanphams → danhmuc
            'id_sp',      // FK trên bảng bienthe → sanpham
            'id',         // PK của danhmuc
            'id'          // PK của sanpham
        );
    }
}
