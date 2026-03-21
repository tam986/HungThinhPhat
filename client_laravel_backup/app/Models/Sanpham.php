<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    use HasFactory;
    protected $table = 'sanphams';
    protected $primaryKey = 'id';
    protected $fillable = ['tensp', 'id_danhmuc', 'id_nhacungcap', 'img', 'luotxem', 'anhien', 'mota', 'deleted_at'];
    public $timestamps = true;
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'id_danhmuc', 'id');
    }

    public function nhacungcap()
    {
        return $this->belongsTo(Nhacungcap::class, 'id_nhacungcap', 'id');
    }
    public function bienthe()
    {
        return $this->hasMany(Bienthe::class, 'id_sp');
    }
    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/uploads/img-sanpham/' . $this->img) : null;
    }
}
