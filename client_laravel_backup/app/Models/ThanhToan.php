<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanhtoan';
    protected $primaryKey = 'id';
    protected $fillable = ['id_donhang', 'phuongthucthanhtoan', 'magiaodich', 'trangthai',   'sotienthanhtoan', 'created_at', 'updated_at'];
    public function donhang()
    {
        return $this->belongsTo(DonHang::class, 'id_donhang', 'id');
    }
}
