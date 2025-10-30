<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienThe extends Model
{
    use HasFactory;
    protected $table = 'bienthe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_sp',
        'id_khoiluong',
        'id_nhanbanh',
        'hinh',
        'soluong',
        'slug',
        'gia',
        'giakm',
        'anhien'
    ];
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp', 'id');
    }

    public function khoiluong()
    {
        return $this->belongsTo(Khoiluong::class, 'id_khoiluong', 'id');
    }

    public function nhanbanh()
    {
        return $this->belongsTo(Nhanbanh::class, 'id_nhanbanh', 'id');
    }
    public function donhangchitiet()
    {
        return $this->hasMany(DonHangChiTiet::class, 'id_bienthe', 'id');
    }
    public function binhluan()
    {
        return $this->hasMany(BinhLuan::class, 'id_bienthe')->where('trangthai', 'đã duyệt');
    }
    protected $casts = [
        'gia' => 'float',
        'giakm' => 'float',
        'soluong' => 'integer',
    ];
}
