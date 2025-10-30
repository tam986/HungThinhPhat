<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magiamgia extends Model
{
    use HasFactory;
    protected $table = 'phieugiamgia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'magiamgia',
        'thoidiembatdau',
        'thoidiemketthuc',
        'hesogiamgia',
        'sotientoithieu',
        'trangthai',
        'mota',
        'soluong'
    ];
    public function donhangs()
    {
        return $this->hasMany(DonHang::class, 'id_giamgia');
    }
}
