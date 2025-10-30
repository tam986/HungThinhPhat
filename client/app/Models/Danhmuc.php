<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danhmuc extends Model
{
    use HasFactory;
    protected $table = 'danhmucs';
    protected $primaryKey = 'id';
    protected $fillable = ['tendanhmuc', 'mota', 'thutu'];
    public $timestamps = true;
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_danhmuc', 'id');
    }
}
