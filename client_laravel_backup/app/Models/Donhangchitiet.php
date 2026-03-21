<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHangChiTiet extends Model
{
    protected $table = 'donhangchitiet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_donhang',
        'id_bienthe',
        'soluong',
        'gia',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    public function donhang()
    {
        return $this->belongsTo(Donhang::class, 'id_donhang', 'id');
    }

    public function bienthe()
    {
        return $this->belongsTo(BienThe::class, 'id_bienthe', 'id');
    }
}
