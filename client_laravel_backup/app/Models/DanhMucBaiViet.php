<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhMucBaiViet extends Model
{
    use HasFactory;
    protected $table = 'danh_muc_bai_viet';
    protected $primaryKey = 'id';
    protected $fillable = ['tendm', 'thutu', 'anhien'];
    public $timestamps = true;
    public function baiviet()
    {
        return $this->hasMany(Baiviet::class, 'id_danhmuc', 'id');
    }
}
