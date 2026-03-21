<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Khoiluong;

class Bienthe extends Model
{
    use HasFactory;
    protected $table = 'bienthe';
    protected $primaryKey = 'id';
  public $timestamps = true;
    protected $fillable = ['id_sp', 'id_khoiluong','id_nhanbanh', 'gia', 'giakm', 'hinh', 'soluong', 'slug'];

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp');
    }

    public function khoiluong()
    {
        return $this->belongsTo(Khoiluong::class, 'id_khoiluong');
    }
    public function nhanbanh()
    {
        return $this->belongsTo(Nhanbanh::class, 'id_nhanbanh', 'id');
    }
    public function donhangchitiet()
    {
        return $this->hasMany(Donhangchitiet::class, 'id_bienthe', 'id');
    }
    public function binhluans()
    {
        return $this->hasMany(BinhLuan::class,'id_bienthe');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/uploads/img-sanpham/' . $this->hinh);
    }
}
