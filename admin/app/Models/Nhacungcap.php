<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nhacungcap extends Model
{
    use HasFactory;
    protected $table = 'nhacungcaps';
    protected $primaryKey = 'id';
    protected $fillable = ['tennhacungcap'];
    // 1-N
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_nhacungcap', 'id');
    }
}