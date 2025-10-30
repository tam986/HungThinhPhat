<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sanpham extends Model

{
    use HasFactory, SoftDeletes;
    protected $table = 'sanphams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tensp',
        'id_danhmuc',
        'id_nhacungcap',
        'img',
        'luotxem',
        'anhien',
        'mota',
    ];
    public $timestamps = true;
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'id_danhmuc', 'id');
    }

    // 1-1
    public function nhacungcap()
    {
        return $this->belongsTo(Nhacungcap::class, 'id_nhacungcap', 'id');
    }

    // 1-N
    public function bienthe()
    {
        return $this->hasMany(BienThe::class, 'id_sp', 'id');
    }

    //TongSoluong
    public function getBientheSumSoluong()
    {
        return $this->bienthe->sum('soluong');
    }
}
