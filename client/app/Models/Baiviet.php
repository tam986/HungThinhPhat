<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baiviet extends Model

{
    use HasFactory, SoftDeletes;
    protected $table = 'baiviets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tieude',
        'noidung',
        'anhdaidien',
        'motangan',
        'seotieude',
        'seotukhoa',
        'luotxem',
        'id_danhmuc',
        'anhien',

    ];
    public $timestamps = true;
    public function danhmuc()
    {
        return $this->belongsTo(DanhMucBaiViet::class, 'id_danhmuc', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
