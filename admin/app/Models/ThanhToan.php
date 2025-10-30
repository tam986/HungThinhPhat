<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table ='thanhtoan';
    protected $primaryKey='id';
    protected $fillable = ['id_donhang', 'phuongthucthanhtoan' , 'magiaodich' ,'trangthai' ,   'sotienthanhtoan'];
     public $timestamps = true;
    public function donhang()
    {
        return $this->belongsTo(DonHang::class, 'id_donhang', 'id');
    }
}