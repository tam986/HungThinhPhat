<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nhacungcap extends Model
{
    use HasFactory;
    protected $table = 'nhacungcaps';
    protected $primaryKey = 'id';
    protected $fillable = ['tennhacungcap', 'thutu', 'anhien', 'img'];
    protected $appends = ['img_url', 'hinhanh_url'];

    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : null;
    }

    public function getHinhanhUrlAttribute()
    {
        return $this->getImgUrlAttribute();
    }
    // 1-N
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_nhacungcap', 'id');
    }
}