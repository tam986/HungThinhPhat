<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donhang extends Model
{
  use HasFactory;
  protected $table = 'donhangs';
  protected $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
    'id_user',
    'phone',
    'tennguoinhan',
    'tongtien',
    'sotiengiam',
    'thanhtien',
    'email',
    'diachi',
    'tienvc',
    'trangthai',
    'id_giamgia',
    'ghichu'
  ];
  public function donhangchitiet()
  {
    return $this->hasMany(Donhangchitiet::class, 'id_donhang', 'id');
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }
  public function phieuGiamGia()
  {
    return $this->belongsTo(Magiamgia::class, 'id_giamgia', 'id');
  }

  public function thanhToan()
  {
    return $this->hasOne(Thanhtoan::class, 'id_donhang', 'id');
  }
}
